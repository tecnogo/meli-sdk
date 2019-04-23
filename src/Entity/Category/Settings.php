<?php

namespace Tecnogo\MeliSdk\Entity\Category;


use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class Settings
 *
 * @package Tecnogo\MeliSdk\Entity\Category
 *
 * @internal
 */
final class Settings extends AbstractEntity
{
    /**
     * @return bool
     */
    public function adultContent()
    {
        return $this->get('adult_content');
    }

    /**
     * @return bool
     */
    public function buyingAllowed()
    {
        return $this->get('buying_allowed');
    }

    /**
     * @return array
     */
    public function buyingModes()
    {
        return $this->get('buying_modes');
    }

    /**
     * @return string
     */
    public function coverageAreas()
    {
        return $this->get('coverage_areas');
    }

    /**
     * @return array
     */
    public function currencies()
    {
        return $this->get('currencies');
    }

    /**
     * @return bool
     */
    public function fragile()
    {
        return $this->get('fragile');
    }

    /**
     * @return string
     */
    public function immediatePayment()
    {
        return $this->get('immediate_payment');
    }

    /**
     * @return array
     */
    public function itemConditions()
    {
        return $this->get('item_conditions');
    }

    /**
     * @return bool
     */
    public function itemsReviewsAllowed()
    {
        return $this->get('items_reviews_allowed');
    }

    /**
     * @return int
     */
    public function maxDescriptionLength()
    {
        return $this->get('max_description_length');
    }

    /**
     * @return int
     */
    public function maxPicturesPerItem()
    {
        return $this->get('max_pictures_per_item');
    }

    /**
     * @return int
     */
    public function maxSubTitleLength()
    {
        return $this->get('max_sub_title_length');
    }

    /**
     * @return int
     */
    public function maxTitleLength()
    {
        return $this->get('max_title_length');
    }

    /**
     * @return string
     */
    public function price()
    {
        return $this->get('price');
    }

    /**
     * @return array
     */
    public function restrictions()
    {
        return $this->get('restrictions');
    }

    /**
     * @return bool
     */
    public function roundedAddress()
    {
        return $this->get('rounded_address');
    }

    /**
     * @return string
     */
    public function sellerContact()
    {
        return $this->get('seller_contact');
    }

    /**
     * @return array
     */
    public function shippingModes()
    {
        return $this->get('shipping_modes');
    }

    /**
     * @return array
     */
    public function shippingOptions()
    {
        return $this->get('shipping_options');
    }

    /**
     * @return string
     */
    public function shippingProfile()
    {
        return $this->get('shipping_profile');
    }

    /**
     * @return bool
     */
    public function showContactInformation()
    {
        return $this->get('show_contact_information');
    }

    /**
     * @return string
     */
    public function simpleShipping()
    {
        return $this->get('simple_shipping');
    }

    /**
     * @return string
     */
    public function stock()
    {
        return $this->get('stock');
    }

    /**
     * @return mixed
     */
    public function subVertical()
    {
        return $this->get('sub_vertical');
    }

    /**
     * @return array
     */
    public function tags()
    {
        return $this->get('tags');
    }

    /**
     * @return mixed
     */
    public function vertical()
    {
        return $this->get('vertical');
    }

    /**
     * @return string
     */
    public function vipSubdomain()
    {
        return $this->get('vip_subdomain');
    }

    /**
     * @return mixed
     */
    public function mirrorCategory()
    {
        return $this->get('mirror_category');
    }

    /**
     * @return bool
     */
    public function listingAllowed()
    {
        return $this->get('listing_allowed');
    }

    /**
     * @return mixed
     */
    public function maximumPrice()
    {
        return $this->get('maximum_price');
    }

    /**
     * @return mixed
     */
    public function minimumPrice()
    {
        return $this->get('minimum_price');
    }
}