<?php

namespace adminBundle\Controller;

use adminBundle\Entity\Categorie;
use adminBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;



class CategorieController extends Controller
{
    private $products;

    /*
    public function __construct()
    {
        $this->products = [
        1 => [
            "id" => 12,
            "title" => "Homme",
            "description" => "lorem ipsum \n suite du contenu",
            "date_created" => new \DateTime('now'),
            "active" => true
        ],
        2 => [
            "id" => 2,
            "title" => "Femme",
            "description" => "<strong>lorem</strong> ipsum",
            "date_created" => new \DateTime('-10 Days'),
            "active" => true
        ],
        3 => [
            "id" => 3,
            "title" => "Enfant",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-1 Days'),
            "active" => false
        ]
    ];
    }
    */

    /**
     * @Route("/admin/categories", name="categories")
     */
    public function categorieAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository("adminBundle:Categorie")->findAll();

        return $this->render('Categories/categories.html.twig',
                             [
                               'categories' => $categories,
                               'firstname' => "Charlie",
                                'lastname' => "BELIER"
                             ]);
    }

    /**
     * @Route("/admin/categories/{id}", name="show_categorie", requirements={"id" = "\d+"})
     *
     * @ParamConverter("categorie", class="adminBundle:Categorie")
     */
    public function showCategorieAction(Categorie $categorie){

        /*
              $em = $this->getDoctrine()->getManager();
              $categories = $em->getRepository("adminBundle:Categorie")->find($id);
              */


        /*
        foreach ($this->products as $product)
        {
            if ($product["id"]==$id)
            {
                $produit = $product;
            }
        }


        if (empty($categories)){
            throw $this->createNotFoundException("La catégorie n'hexiste pas !");
        }

              */


        return $this->render('Categories/indivCat.html.twig',
            [
                'firstname' => "Charlie",
                'categorie' => $categorie,
                'lastname' => "BELIER"
            ]);
    }


    /**
     * @Route("admin/categories/creer", name="categorie_create")
     */
    public function createAction(Request $request)
    {
        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em -> persist($categorie);//Doctrine est au courant des changements
            $em -> flush();//On force
            // sauvegarde du produit

            $this->addFlash('success', 'Votre categorie a bien été ajouté');

            return $this->redirectToRoute('categories');
        }

        return $this->render('Categories/create.html.twig', ['formCategorie' => $formCategorie->createView()]);
    }

    /**
     * @Route("admin/categories/editer/{id}", name="categorie_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('adminBundle:Categorie')->find($id);

        // Vérification si le produit est bien en BDD
        if (!$categorie) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        // Création du formulaire ProductType permettant de créer un produit
        // Je lie le formulaire à mon objet $product
        $formCategorie = $this->createForm(CategorieType::class, $categorie);

        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formCategorie->handleRequest($request);

        // Je valide mon formulaire
        if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {

            // La ligne ci-dessous n'est pas obligatoire car doctrine est au courant de l'existance de $product
            // $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Votre categorie a été mis à jour');

            return $this->redirectToRoute('categories', ['id' => $id]);
        }

        return $this->render('Categories/edit.html.twig', ['formCategorie' => $formCategorie->createView()]);
    }

    /**
     * @Route("admin/categories/supprimer/{id}", name="categorie_remove")
     */
    public function removeAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('adminBundle:Categorie')->find($id);

        // Vérification si le produit est bien en BDD
        if (!$categorie) {
            throw $this->createNotFoundException("La categories n'existe pas");
        }

        $em->remove($categorie);
        $em->flush();

        $messageSuccess = 'Votre produit a été supprimé';


        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(['message' => $messageSuccess]);
        }

        $this->addFlash('success', $messageSuccess);

        // Redirection sur la page qui liste tous les produits
        return $this->redirectToRoute('categories');
    }


}
