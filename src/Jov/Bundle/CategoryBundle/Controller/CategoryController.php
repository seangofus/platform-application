<?php

namespace Jov\Bundle\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Jov\Bundle\CategoryBundle\Entity\Category;

/**
 * Jovial Category controller.
 *
 * @Route("/categories")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     * @Route("/", name="jov_category")
     * @Acl(
     *      id="jov_category",
     *      type="entity",
     *      class="JovCategoryBundle:Category",
     *      permission="VIEW"
     * )
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/view/{id}/", name="jov_category_view", requirements={"id"="\d+"})
     * @Acl(
     *      id="jov_category_view",
     *      type="entity",
     *      class="JovCategoryBundle:Category",
     *      permission="VIEW"
     * )
     * @Template
     */
    public function viewAction(Category $entity)
    {
        return array('entity' => $entity);
    }


    /**
     * @Route("/create/", name="jov_category_create")
     * @Acl(
     *      id="jov_category_create",
     *      type="entity",
     *      class="JovCategoryBundle:Category",
     *      permission="CREATE"
     * )
     * @Template("JovCategoryBundle:Category:update.html.twig")
     */
    public function createAction()
    {
        $category = new Category();
        return $this->update($category);
    }

    /**
     * @Route("/update/{id}/", name="jov_category_update", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="jov_category_update",
     *      type="entity",
     *      class="JovCategoryBundle:Category",
     *      permission="EDIT"
     * )
     */
    public function updateAction(Category $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Category $entity
     * @return array
     */
    protected function update(Category $entity)
    {
        $saved = false;
        $request = $this->getRequest();
        $form = $this->createForm($this->getFormType(), $entity);

        if ( $request->isMethod('POST') ) {
            $form->submit($request);
            if ( $form->isValid() ) {

                $this->getDoctrine()->getManager()->persist($entity);
                $this->getDoctrine()->getManager()->flush();

                $saved =  true;

                if ( !$this->getRequest()->request->has('_widgetContainer') ) {
                    $this->get('session')->getFlashBag()->add('success', 'Successfully saved the Category.');

                    return $this->get('oro_ui.router')->redirectAfterSave(
                        array(
                            'route' => 'jov_category_update',
                            'parameters' => array('id' => $entity->getId()),
                        ),
                        array(
                            'route' => 'jov_category_view',
                            'parameters' => array('id' => $entity->getId()),
                        )
                    );
                }
            }
        }

        return array(
            'saved' => $saved,
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * @return CategoryType
     */
    protected function getFormType()
    {
        return $this->get('jov_category.form.type.category');
    }
}
