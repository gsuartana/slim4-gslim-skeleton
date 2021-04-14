<?php

namespace Gslim\App\Helpers\Normalizer;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * Class Normalizer
 * @package Gslim\App\Helpers\Normalizer
 *
 * @author gede.suartana <gede.suartana@outlook.com>
 */
Class Normalizer extends GetSetMethodNormalizer
{
    /**
     * Normalizes an object into a set of arrays/scalars
     *
     * @param mixed $object
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $data = parent::normalize($object, $format, $context);
        return array_filter($data, function ($field) {
            return $field !== null;
        });
    }

}