<?php

namespace Tecnogo\MeliSdk\Entity\User;

use Tecnogo\MeliSdk\Entity\AbstractEntity;

/**
 * Class User
 *
 * @package Tecnogo\MeliSdk\Entity\User
 *
 * @internal
 */
class User extends AbstractEntity
{
    /**
     * @return int|null
     */
    public function id()
    {
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function nickname()
    {
        return $this->get('nickname');
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->get('first_name');
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->get('last_name');
    }

    /**
     * @return string
     */
    public function permalink()
    {
        return $this->get('permalink');
    }

    /**
     * @return string[]
     */
    public function tags()
    {
        return $this->get('tags', []);
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function hasTag($tag)
    {
        return in_array($tag, $this->tags());
    }

    /**
     * @return bool
     */
    public function verified()
    {
        return $this->hasTag(Tag::USER_INFO_VERIFIED);
    }

    /**
     * @return bool
     */
    public function developer()
    {
        return $this->hasTag(Tag::USER_DEVELOPER);
    }
}

/*
Array
        (
            [id] => 136244363
            [nickname] => AIJOONA
            [registration_date] => 2013-04-08T14:49:29.000-04:00
            [first_name] => Valentin
            [last_name] => Starck
            [gender] =>
            [country_id] => AR
            [email] => valentin@starck.im
            [identification] => Array
                (
                    [number] => 32365822
                    [type] => DNI
                )

            [internal_tags] => Array
                (
                    [0] => developer
                )

            [address] => Array
                (
                    [address] => Presidente Perón 1854
                    [city] => Adrogué
                    [state] => AR-B
                    [zip_code] => 1852
                )

            [phone] => Array
                (
                    [area_code] =>
                    [extension] =>
                    [number] => 011 15 37890152
                    [verified] =>
                )

            [alternative_phone] => Array
                (
                    [area_code] =>
                    [extension] =>
                    [number] =>
                )

            [user_type] => normal
            [tags] => Array
                (
                    [0] => normal
                    [1] => user_info_verified
                    [2] => developer
                    [3] => messages_as_seller
                    [4] => messages_as_buyer
                )

            [logo] =>
            [points] => 105
            [site_id] => MLA
            [permalink] => http://perfil.mercadolibre.com.ar/AIJOONA
            [shipping_modes] => Array
                (
                    [0] => custom
                    [1] => not_specified
                )

            [seller_experience] => INTERMEDIATE
            [bill_data] => Array
                (
                    [accept_credit_note] =>
                )

            [seller_reputation] => Array
                (
                    [level_id] =>
                    [power_seller_status] =>
                    [transactions] => Array
                        (
                            [canceled] => 0
                            [completed] => 2
                            [period] => historic
                            [ratings] => Array
                                (
                                    [negative] => 0
                                    [neutral] => 0
                                    [positive] => 1
                                )

                            [total] => 2
                        )

                    [metrics] => Array
                        (
                            [sales] => Array
                                (
                                    [period] => 60 months
                                    [completed] => 2
                                )

                            [claims] => Array
                                (
                                    [period] => 60 months
                                    [rate] => 0
                                )

                            [delayed_handling_time] => Array
                                (
                                    [period] => 60 months
                                    [rate] => 0
                                )

                        )

                )

            [buyer_reputation] => Array
                (
                    [canceled_transactions] => 0
                    [tags] => Array
                        (
                        )

                    [transactions] => Array
                        (
                            [canceled] => Array
                                (
                                    [paid] =>
                                    [total] =>
                                )

                            [completed] =>
                            [not_yet_rated] => Array
                                (
                                    [paid] =>
                                    [total] =>
                                    [units] =>
                                )

                            [period] => historic
                            [total] =>
                            [unrated] => Array
                                (
                                    [paid] =>
                                    [total] =>
                                )

                        )

                )

            [status] => Array
                (
                    [billing] => Array
                        (
                            [allow] => 1
                            [codes] => Array
                                (
                                )

                        )

                    [buy] => Array
                        (
                            [allow] => 1
                            [codes] => Array
                                (
                                )

                            [immediate_payment] => Array
                                (
                                    [reasons] => Array
                                        (
                                        )

                                    [required] =>
                                )

                        )

                    [confirmed_email] => 1
                    [shopping_cart] => Array
                        (
                            [buy] => allowed
                            [sell] => allowed
                        )

                    [immediate_payment] =>
                    [list] => Array
                        (
                            [allow] => 1
                            [codes] => Array
                                (
                                )

                            [immediate_payment] => Array
                                (
                                    [reasons] => Array
                                        (
                                        )

                                    [required] =>
                                )

                        )

                    [mercadoenvios] => not_accepted
                    [mercadopago_account_type] => personal
                    [mercadopago_tc_accepted] => 1
                    [required_action] =>
                    [sell] => Array
                        (
                            [allow] => 1
                            [codes] => Array
                                (
                                )

                            [immediate_payment] => Array
                                (
                                    [reasons] => Array
                                        (
                                        )

                                    [required] =>
                                )

                        )

                    [site_status] => active
                    [user_type] => simple_registration
                )

            [secure_email] => vstarck.hjlbtz@mail.mercadolibre.com
            [credit] => Array
                (
                    [consumed] => 0
                    [credit_level_id] => MLA5
                    [rank] => newbie
                )

            [context] => Array
                (
                )

        )


 */