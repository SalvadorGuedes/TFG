<?php

namespace generalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use generalBundle\Entity\consulta;

class BusquedaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', EntityType::class, array(
                        'class' => 'generalBundle:consulta',
                        'required' => true,
                        'expanded' => true,
                        'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('u')
                                    ->where('u.activo = :activo')
                                    ->orderBy('u.name', 'ASC')
                                    ->setParameter('activo', 1);
                            ;
                        },
                        'choice_label' => 'name',
                        'attr' => array(
                            'class' => 'formulario_busqueda_Consulta'
                        )))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => consulta::class
        ));
    }

}
