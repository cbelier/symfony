<?php

namespace adminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use adminBundle\Entity\Product;
use adminBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    private $products;

    /**
     * @Route("/admin/products", name="products")
     */
    public function productAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("adminBundle:Product")->findAll();
        $somme= 0;
        $moyenne = 0;
        $i = 0;
        $tab = [];
        $mini = 99999;


        foreach ($products as $product)
        {
            $i++;
            $somme += $product->getPrice();

            if ($mini>$product->getPrice()) {
                $mini = $product->getPrice();
            }
            //$tab[$i]=serialize($product->getDate());
        }

        $Nb = sizeof($products);
        $moyenne = $somme/$Nb;


        return $this->render('Products/products.html.twig',
                             [
                               'products' => $products,
                                 'moyenne' => $moyenne,
                                 'prix_mini' => $mini,
                                 'firstname' => "Charlie",
                                 //'dates' => $tab,
                                'lastname' => "BELIER"
                             ]);
    }

    /**
     * @Route("/admin/products/{id}", name="show_product", requirements={"id" = "\d+"})
     */
    public function showProductAction($id){


        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")->find($id);
        /*
        foreach ($this->products as $product)
        {
            if ($product["id"]==$id)
            {
                $produit = $product;
            }
        }
        */

        if (empty($product)){
            throw $this->createNotFoundException("Le produit n'hexiste pas !");
        }



        return $this->render('Products/indivProducts.html.twig',
            [
                'firstname' => "Charlie",
                'product' => $product,
                'lastname' => "BELIER"
            ]);
    }

    /**
     * @Route("admin/products/creer", name="product_create")
     */
    public function createAction(Request $request)
    {
        $product = new Product();
        $formProduct = $this->createForm(ProductType::class, $product);
        $formProduct->handleRequest($request);



        if ($formProduct->isSubmitted() && $formProduct->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em -> persist($product);//Doctrine est au courant des changements
            $em -> flush();//On force
            // sauvegarde du produit

            $this->addFlash('success', 'Votre produit a bien été ajouté');

            return $this->redirectToRoute('product_create');
        }

        return $this->render('Products/create.html.twig', ['formProduct' => $formProduct->createView()]);
    }

    /**
     * @Route("admin/products/editer/{id}", name="product_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')->find($id);

        // Vérification si le produit est bien en BDD
        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        // Création du formulaire ProductType permettant de créer un produit
        // Je lie le formulaire à mon objet $product
        $formProduct = $this->createForm(ProductType::class, $product);

        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formProduct->handleRequest($request);

        // Je valide mon formulaire
        if ($formProduct->isSubmitted() && $formProduct->isValid()) {

            // La ligne ci-dessous n'est pas obligatoire car doctrine est au courant de l'existance de $product
            // $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Votre produit a été mis à jour');

            return $this->redirectToRoute('products', ['id' => $id]);
        }

        return $this->render('Products/edit.html.twig', ['formProduct' => $formProduct->createView()]);
    }

    /**
     * @Route("admin/products/supprimer/{id}", name="product_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')->find($id);

        // Vérification si le produit est bien en BDD
        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Votre produit a été supprimé');

        // Redirection sur la page qui liste tous les produits
        return $this->redirectToRoute('products');
    }

    /**
     * @Route("admin/products/supprimerProduits", name="product_removeMany")
     */
    public function removeMany(Request $request)
    {
        die(dump($request));
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('adminBundle:Product')->find($tableauID);

        // Vérification si le produit est bien en BDD
        if (!$product) {
            throw $this->createNotFoundException("Le produit n'existe pas");
        }

        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Votre produit a été supprimé');

        // Redirection sur la page qui liste tous les produits
        return $this->redirectToRoute('products');
    }
}
