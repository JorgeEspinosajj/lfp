<?php

namespace App\Form;

use App\Entity\Estadio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class EstadioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nombre')
            ->add('Foto', FileType::class, [
                'label' => 'Foto',

                
                'mapped' => false,

                
                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/pjpeg',
                        ],
                        'mimeTypesMessage' => 'Una imagen por favor',
                    ])
                ],
            ])
            ->add('Capacidad')
            ->add('Fecha_Ing',DateType::class,array(
                'widget' =>'single_text',
                'input_format'=>'d-m-y',
                'years' => range(date('Y'),date('Y')-100),
                'months' => range(date('m'),12),
                'days' =>range(1,31),
            ))
            ->add('Ciudad')
            ->add('Equipo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Estadio::class,
        ]);
    }
}
