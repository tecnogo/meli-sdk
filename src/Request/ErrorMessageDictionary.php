<?php

namespace Tecnogo\MeliSdk\Request;

/**
 * Class ErrorMessageDictionary
 *
 * @package Tecnogo\MeliSdk\Request
 */
final class ErrorMessageDictionary
{
    const FAILED_TO_VALIDATE_TOKEN = 'Failed to validate token';
    const MESSAGES_RETRIEVE_REQUIRED_APP_ID = 'You must send an app_id in order to retrieve the messages';
    const ITEM_ALREADY_BOOKMARKED = 'You are already following this item.';
    const INVALID_LOGIN_CODE = 'credenciales inv&aacute;lidas';
}
