<?php

namespace AppBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class UserDatatable
 *
 * @package AppBundle\Datatables
 */
class UserDatatable extends AbstractDatatableView
{
    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->features->set(array(
            'auto_width' => true,
            'defer_render' => false,
            'info' => true,
            'jquery_ui' => false,
            'length_change' => true,
            'ordering' => true,
            'paging' => true,
            'processing' => true,
            'scroll_x' => false,
            'scroll_y' => '',
            'searching' => true,
            'state_save' => false,
            'delay' => 0,
            'extensions' => array('responsive' => true),
            'highlight' => false,
            'highlight_color' => 'red'
        ));

        $this->ajax->set(array(
            'url' => $this->router->generate('user_results'),
            'type' => 'GET',
            'pipeline' => 0
        ));

        $this->options->set(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => 'lfrtip',
            'length_menu' => array(10, 25, 30, 50, 100),
            'order_classes' => true,
            'order' => array(array(3, 'asc'), array(2, 'asc'), array(4, 'asc')),
            'order_multi' => true,
            'page_length' => 30,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' => '',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'stripe_classes' => array(),
            'class' => Style::BOOTSTRAP_3_STYLE,
            'individual_filtering' => false,
            'individual_filtering_position' => 'head',
            'use_integration_options' => true,
            'force_dom' => false,
            'row_id' => 'id'
        ));

        $context = $this->router->getContext();
        $this->columnBuilder
            ->add('id', 'column', array(
                'visible' => false
            ))
            ->add('avatar', 'image', array(
                'title' => $this->translator->trans('datatable.user.avatar.title'),
                'relative_path' => 'uploads/user',
                'imagine_filter' => 'my_thumb_40x40',
                'holder_url' => $context->getBaseUrl().'/images/avatar_mini.png',
                'enlarge' => true
            ))
            ->add('firstName', 'column', array(
                'title' => $this->translator->trans('datatable.user.firstName.title'),
            ))
            ->add('lastName', 'column', array(
                'title' => $this->translator->trans('datatable.user.lastName.title'),
            ))
            ->add('email', 'column', array(
                'title' => $this->translator->trans('datatable.user.email.title'),
            ))
            ->add('enabled', 'boolean', array(
                'title' => '<i class=\"fa fa-toggle-on\"></i>',
                'true_icon' => 'glyphicon glyphicon-ok text-success',
                'false_icon' => 'glyphicon glyphicon-remove text-danger',
            ))
            ->add(null, 'action', array(
                'title' => $this->translator->trans('datatables.actions.title'),
                'actions' => array(
                    array(
                        'route' => 'user_show',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.show'),
                            'class' => 'btn btn-default btn-xs',
                            'role' => 'button'
                        ),
                        'render_if' => function($row) {
                            return (
                                $this->authorizationChecker->isGranted('ROLE_USERS_SHOW')
                            );
                        },
                    ),
                    array(
                        'route' => 'user_edit',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => $this->translator->trans('datatables.actions.edit'),
                            'class' => 'btn btn-default btn-xs',
                            'role' => 'button'
                        ),
                        'render_if' => function($row) {
                            return (
                                $this->authorizationChecker->isGranted('ROLE_USERS_EDIT')
                            );
                        },
                    )
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'AppBundle\Entity\User';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_datatable';
    }
}
