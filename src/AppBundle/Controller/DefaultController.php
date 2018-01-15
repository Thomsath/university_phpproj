<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Form\CodeBarreType;
use AppBundle\Form\RegistrationType;
use AppBundle\Entity\Product;
use AppBundle\Form\NotationsType;
use AppBundle\Entity\Evaluation;
use \Datetime;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(CodeBarreType::class);
        $em = $this->getDoctrine()->getManager();

        // On va chercher les produits les plus consultés
        $consult = $em
                    ->getRepository(Product::class)
                    ->findBy(array(), array('dateDerniereVue' => 'desc'), 8);

        // On va chercher les produits les mieux notés 
        $bestProd = $em
                    ->getRepository(Product::class)
                    ->findBestProducts();
        $i = 0;


        if(sizeof($bestProd) == 0 ) {
            $bestProd_none = "Aucun produit pour l'instant !";
        }
        else {
             $i = 0;
             $bestProd_none = "";
            // Liste produits non vide donc on peut déterminer les meilleurs produits
            foreach($bestProd as $best) {
                
                $cb_bestnote = $bestProd[$i]["code_barre"];
                $cb_bestnote_tab[$i] = $bestProd[$i]["code_barre"];
                //  On recherche le produit sur l'API
                $json = file_get_contents("https://fr.openfoodfacts.org/api/v0/produit/" . $cb_bestnote);
                $data_besnote = json_decode($json, true);

                $picture_bestnote[$i] = $data_besnote['product']['image_url'];
                $prod_name_bestnote[$i] = $data_besnote['product']['product_name'];

                //$id[$i] = $bestProd[$i]["product_id"];
                //$note[$i] = $bestProd[$i]["AVG(note)"];
                $i++;
            }
        }
        if(sizeof($consult) == 0 ) {
           $consult_none = "Aucun produit pour l'instant !";
        }
        else {
            $consult_none = "";
            $i = 0;
            foreach ($consult as $consultation){
                $cb =  $consultation->getCodeBarre();
                $cb_tab[$i] = $consultation->getCodeBarre();
                $json = file_get_contents("https://fr.openfoodfacts.org/api/v0/produit/" . $cb);
                $data = json_decode($json, true);


                // Amélioration : 1 tableau associatif
                $tab_name[$i] = $data['product']['product_name'];
                $tab_pic[$i] = $data['product']['image_url'];
                $i++;
                }
            }
        return [
            'form' => $form->createView(),
            'cb' => $cb,
            'cb_tab' => $cb_tab,
            'tab_consult' => $consult,
            'tab_name' => $tab_name,
            'tab_pic' => $tab_pic,
            'prodname_bestnote' => $prod_name_bestnote,
            'prodpic_bestnote' => $picture_bestnote,
            'cb_bestnote' => $cb_bestnote,
            'cb_bestnote_tab' => $cb_bestnote_tab,
            'consult_none' => $consult_none,
            'bestProd_none' => $bestProd_none
        ];
    }

    /**
     * @Route("/search", name="search")
     * @Template("search.html.twig")
     */
    public function searchAction(Request $request)
    {
        $form = $this->createForm(CodeBarreType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $code_barre = $data['code_barre'];
            //
            // XXX: A faire, chercher si le produit existe, le créer en
            // base et rediriger le visiteur vers la fiche produit
            return $this->redirectToRoute('product', array('code_barre' => $code_barre));
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/product/code_barre={code_barre}/", name="product")
     * @Template("product.html.twig")
     */
    public function productAction($code_barre)
    {
            $json = file_get_contents("https://fr.openfoodfacts.org/api/v0/produit/" . $code_barre);
            $data = json_decode($json, true);
            // On vérifie l'existence et la validité du code barre
            if($data['status'] == 0) {
                $error = "Produit non trouvé, code barre invalide";
                return [
                    'error' => $error
                ];
            }
            // Si le code barres est bon !
            else {

            // On vérifie si le produit existe dans la bdd
            if(!$product = $this->getDoctrine()
                    ->getRepository(Product::class)
                    ->findOneBycodeBarre($code_barre)){
                // Si il n'existe pas, on le créé

                $product = new Product();
                $product->setCodeBarre($code_barre);
                $product->setNbConsultations(1);
                $product->setDateDerniereVue(new DateTime);
                $em = $this->getDoctrine()->getManager();

                // on fait le lien entre doctrine et l'objet
                $em->persist($product);
                $em->flush();
                
            }
            else {   
            
            // Si il existe, on incrémente le nb de consultations + modif date consultation
            $product = $this->getDoctrine()
                    ->getRepository(Product::class)
                    ->findOneBycodeBarre($code_barre);
            $product->setNbConsultations($product->getNbConsultations() + 1);
            $product->setDateDerniereVue(new DateTime);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            }

            //  Partie formulaire de notation d'un produit QUESTION 6
             $user = $this->getUser();
            $user_id = $user->getId();
            $prod_id = $product->getId();
           $existbdd = $em
                     ->getRepository(Evaluation::class)
                     ->findMarkUser($user_id, $prod_id);
                     
            // Ici on test si l'utilisateur a déjà voté ou non         
            if(sizeof($existbdd) == 0) {
                $form_status = 1;
                $mark = new Evaluation();
                $form = $this->createForm(NotationsType::class, $mark);
                if ($form->isSubmitted() && $form->isValid()) {
                    $mark = $form->getData();
                    var_dump($mark);
                    die();
                    $mark->persist();
                    $mark->flush();
                    // si form bon >>> redirect homepage
                    return $this->redirectToRoute('homepage');
                }
            }
            else {
                $form_status = 0;
            }

            // On récupère les meilleus notes pour un produit  via le repo QUESTION 7
                $avg_note = $this->getDoctrine()
                            ->getRepository(Product::class)
                            ->findBestNote();

            $picture = $data['product']['image_url']."\n";
            $brand = $data['product']['brands_tags'][0]."\n";
            $prod_name = $data['product']['product_name']."\n";
            $nbConsult = $product->getNbConsultations();
            $ingredients = $data['product']['ingredients_text_fr']."\n";
            $ingredients = str_replace("_"," ",$ingredients);
            $ingredients = str_replace("*", "", $ingredients);
            $tab_ingre = explode(", ", $ingredients);           
            return [
                'code_barre' => $code_barre,
                'prod_name' => $prod_name,
                'picture' => $picture,
                'nb_consult' => $nbConsult,
                'tab_ingre' => $tab_ingre,
                //'quantity' => $quantity,
                'form' => $form->createView(),
                'avg_note' => $avg_note,
                'form_status' => $form_status
            ];
        }
    }
}
