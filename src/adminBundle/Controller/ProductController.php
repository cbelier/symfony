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

    public function __construct()
    {
        /*
        $this->products = [
        [
            "id" => 1,
            "title" => "Mon premier produit",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 10
        ],
        [
            "id" => 2,
            "title" => "Mon deuxième produit",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 20
        ],
        [
            "id" => 3,
            "title" => "Mon troisième produit",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 30
        ],
        [
            "id" => 4,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 5,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 6,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 7,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 8,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-9 Days'),
            "prix" => 410
        ],
        [
            "id" => 9,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-110 Days'),
            "prix" => 410
        ],
        [
            "id" => 10,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-10 Days'),
            "prix" => 410
        ],
        [
            "id" => 11,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-1 Days'),
            "prix" => 410
        ]
    ];
        */


    }

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
}
