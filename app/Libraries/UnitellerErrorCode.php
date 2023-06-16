<?php

namespace App\Libraries;

class UnitellerErrorCode
{
    public const SUCCESS = '00000000';
    public const ACTIVE_BANK_ACCOUNT_ALREADY_ADDED = '59908001';
    public const DOC_IMAGE_REQUIRED = '50202001';
    public const ALREADY_EXISTS_IN_PROC_TX = '51107001';
    public const PWD_EXPIRED = '50105001';
    public const DUPLICATE_TX = '51102001';
    public const EMAIL_MIGHT_FAIL = '50102001';
    public const INVALID_PARTNER_CODE = '59903001';
    public const INVALID_TRANSACTION = '51103001';
    public const LIMIT_EXCEED = '51104001';
    public const LOCKED_USER_ID = '50104001';
    public const MAY_UPDATE_APP = '59902901';
    public const NEED_UPDATE_CODE = '59905001';
    public const PAYMENT_FAIL = '51108001';
    public const PERSONAL_INFO_NOT_COMPLETE = '50108001';

    public const INVALID_INTERNAL_TX_REF = '51103002';
    public const INVALID_BENE = '59903002';
    public const DOC_VERIFY_STATUS_PENDING = '50201002';
    public const TX_SAME_INFO_SAME_TIME = '51108002';
    public const BANK_ACCOUNT_ADDED_SAMEDAY = '59908002';
    public const MANUAL_DOC_UPLOAD = '50205002';
    public const PENDING_ACTIVATION_WARNING = '50102002';
    public const SYSTEM_ERROR = '59906002';
    public const TEMP_PWD_CHANGE_REQUIRED = '50107002';
    public const TX_MIGHT_CREATED = '51102002';
    public const UNVERIFIED_BA = '51104002';
    public const USERID_PWD_NO_MATCH = '50105002';
    public const MAX_LIMIT_TX = '51107002';

    public const DUPLICATE_AUTHENTICATION_REQ_WARNING = '50102003';
    public const FRAUD_CHECK_WARNING = '51102903';
    public const INSUFFICIENT_DATA = '50103003';
    public const INVALID_SENDING_METHOD = '59903003';
    public const CREDIT_CARD_EXCEED = '59908003';
    public const PROFILE_NOT_ACTIVE = '50105003';
    public const NO_MODIFICATION = '59902003';
    public const PWD_CHANGE_REQUIRED = '50107003';
    public const UNVERIFIED_CC = '51104003';

    public const DEBIT_CARD_EXCEED = '59908004';
    public const ALREADY_VERIFIED_SENDING_METHOD = '59902004';
    public const CANCEL_TX_DUPLICATE = '51102004';
    public const LOGOUT_INVALID_SESSION = '50108004';
    public const NO_IN_PROC_TX_ALLOW_1 = '51102904';
    public const PROFILE_SUSPENDED_OR_LOCKED = '50105004';
    public const PROVISIONAL_ACTIVE_USER_CODE = '50102004';
    public const PWD_NOT_MATCHED = '50104004';
    public const FOUND_IN_BLACKLIST = '50107004';
    public const UNVERIFIED_DC = '51104004';
    public const SYSTEM_UNAVAILABLE = '59906004';

    public const INVALID_DATA = '59903005';
    public const MALICIOUS_ACCESS = '59907005';
    public const NETWORK_PROBLEM = '59906005';
    public const FOUND_IN_FRAUD = '50107005';
    public const CANCEL_TAKE_TIME_RESPONSE_CODE = '51102005';
    public const QUESTION_DISPLAYED = '50102005';
    public const REGISTER_UNIQUE_SYSTEM_ID = '50105005';
    public const SENDING_METHOD_EXCEED = '59908005';
    public const ULINK_SET_PIN_REQUIRED = '59902005';
    public const UNVERIFIED_UC = '51104005';

    public const AUTHENTICATION_FAILURE = '59907006';
    public const CREDIT_CARD_EXISTS = '59908006';
    public const INVALID_COUNTRY = '59903006';
    public const LIMIT_BA = '51104006';
    public const SECURITY_ANSWER_NOT_MATCHED = '50107006';
    public const SECURITY_QUESTION_ANSWER_REQUIRED = '50102006';
    public const SSN_OR_DOC_UPLOAD = '50105006';

    public const DEBIT_CARD_EXISTS = '59908007';
    public const DOC_UPLOAD_ONLY = '50105007';
    public const INVALID_CURRENCY = '59903007';
    public const LIMIT_CC = '51104007';
    public const PROFILE_ALREADY_SETUP = '50102007';
    public const USER_ALREADY_EXIST = '50107007';

    public const CREDIT_CARD_SAMEDAY = '59908008';
    public const INVALID_PAYER = '59903008';
    public const LIMIT_DC = '51104008';
    public const QUES_ANS_SUCCESS_CODE = '50102008';
    public const SAME_AS_OLD_PWD = '50104008';
    public const PAYER_BRANCH_REQUIRED = '50105008';

    public const AVS_ERR_CARD_NOT_ADDED = '59908011';
    public const BANK_ACCOUNT_VERIFICATION_IS_NOT_ALLOWED = '59908015';
    public const ADMIN_USER_LOGIN = '50105009';
    public const BENE_LIMIT_EXCEED = '59908013';
    public const BENE_NEED_EDIT = '59905003';
    public const BENE_CANNOT_DEACTIVATE = '59901003';
    public const CANCEL_PAID__RESPONSE_CODE = '51104012';
    public const CANCEL_TX_NOALLOWED_AT_THIS_TIME = '51104011';
    public const CREDIT_CARD_VERIFICATION_IS_NOT_ALLOWED = '59908017';
    public const CVV_ERR_CARD_NOT_ADDED = '59908010';
    public const DEBIT_CARD_SAMEDAY = '59908009';
    public const DEBIT_CARD_VERIFICATION_IS_NOT_ALLOWED = '59908016';
    public const EMAIL_NOT_VALIDATED = '50104010';

    public const LOCKED_BANK_ACCOUNT = '59908012';
    public const LOCKED_CREDIT_CARD = '59908014';
    public const LOCKED_DEBIT_CARD = '59908015';
    public const LOGIN_FROM_PORTAL = '59908018';

    public const LIMIT_UC = '51104009';
    public const PWD_NOT_MATCHES_PATTER = '50104009';

    public const TX_NOT_PAYABLE = '51104010';
    public const UIC_SENT_SUCCESS_CODE = '50102010';

    public const TX_NOT_EXIST = '51104013';

    public const BA_DETAILS_NOT_MATCH_WITH_PERSONAL_INFO = '59901001';
    public const SERVICE_UNAVAILABLE = '19906002';
    public const UIC_MATCHED_SUCCESS = '50102009';

    public static string $errorCode;

    /**
     * @param string $errorCode
     *
     * @return void
     */
    public static function setErrorCode(string $errorCode): void
    {
        self::$errorCode = $errorCode;
    }

    /**
     * @return bool
     */
    public static function isSystemError(): bool
    {
        return self::$errorCode === self::SYSTEM_ERROR;
    }

    public static function isInvalidData(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::INVALID_DATA,
                self::INSUFFICIENT_DATA,
                self::USER_ALREADY_EXIST,
                self::PWD_EXPIRED,
                self::PROFILE_ALREADY_SETUP,
                self::INVALID_PARTNER_CODE,
                self::INVALID_CURRENCY,
                self::INVALID_COUNTRY,
                self::SAME_AS_OLD_PWD,
                self::TX_NOT_PAYABLE,
                self::INVALID_INTERNAL_TX_REF,
                self::ALREADY_EXISTS_IN_PROC_TX,
                self::DUPLICATE_AUTHENTICATION_REQ_WARNING,
                self::NO_MODIFICATION,
                self::CANCEL_TX_DUPLICATE,
                self::LIMIT_EXCEED,
                self::PAYMENT_FAIL,
                self::SECURITY_ANSWER_NOT_MATCHED,
                self::FOUND_IN_FRAUD,
                self::CANCEL_PAID__RESPONSE_CODE,
                self::CANCEL_TX_NOALLOWED_AT_THIS_TIME,
                self::CANCEL_TAKE_TIME_RESPONSE_CODE,
            ],
            true
        );
    }

    public static function isInvalidDataBeneficiary(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::INVALID_PAYER,
                self::BENE_LIMIT_EXCEED,
                self::BENE_NEED_EDIT,
                self::BENE_CANNOT_DEACTIVATE,
            ],
            true
        );
    }

    public static function isInvalidSendingMethod(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::CREDIT_CARD_EXISTS,
                self::DEBIT_CARD_SAMEDAY,
                self::DEBIT_CARD_VERIFICATION_IS_NOT_ALLOWED,
                self::CREDIT_CARD_VERIFICATION_IS_NOT_ALLOWED,
                self::DEBIT_CARD_EXISTS,
                self::CREDIT_CARD_SAMEDAY,
                self::CREDIT_CARD_EXCEED,
                self::DEBIT_CARD_EXCEED,
                self::AVS_ERR_CARD_NOT_ADDED,
                self::CVV_ERR_CARD_NOT_ADDED,
                self::LIMIT_BA,
                self::LIMIT_DC,
                self::LIMIT_CC,
                self::INVALID_SENDING_METHOD,
                self::ACTIVE_BANK_ACCOUNT_ALREADY_ADDED,
                self::UNVERIFIED_BA,
                self::BANK_ACCOUNT_ADDED_SAMEDAY,
                self::SENDING_METHOD_EXCEED,
                self::UNVERIFIED_UC,
                self::PAYER_BRANCH_REQUIRED,
                self::BANK_ACCOUNT_VERIFICATION_IS_NOT_ALLOWED,
                self::LOCKED_BANK_ACCOUNT,
                self::LOCKED_CREDIT_CARD,
                self::LOCKED_DEBIT_CARD,
                self::UNVERIFIED_DC,
                self::UNVERIFIED_CC,
                self::BA_DETAILS_NOT_MATCH_WITH_PERSONAL_INFO,
            ],
            true
        );
    }

    /**
     * @return bool
     */
    public static function isNewDevice(): bool
    {
        return self::$errorCode === self::REGISTER_UNIQUE_SYSTEM_ID;
    }

    /**
     * @return bool
     */
    public static function isUic(): bool
    {
        return in_array(
            self::$errorCode,
            [
//            self::PROFILE_NOT_ACTIVE,
                self::UIC_SENT_SUCCESS_CODE,
                self::REGISTER_UNIQUE_SYSTEM_ID,
                '50107001',
            ],
            true
        );
    }

    public static function isLogOut(): bool
    {
        return self::$errorCode === self::LOGOUT_INVALID_SESSION;
    }

    public static function isNotActive(): bool
    {
        return self::$errorCode === self::PROFILE_NOT_ACTIVE;
    }

    /**
     * @return bool
     */
    public static function isSystemFailure(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::NETWORK_PROBLEM,
                self::SYSTEM_UNAVAILABLE,
                self::SERVICE_UNAVAILABLE,
            ],
            true
        );
    }

    /**
     * @return bool
     */
    public static function isFailTransaction(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::MAX_LIMIT_TX,
                self::INVALID_BENE,
                self::TX_SAME_INFO_SAME_TIME,
                self::DUPLICATE_TX,
            ],
            true
        );
    }

    /**
     * @return bool
     */
    public static function isCustomerService(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::PROFILE_SUSPENDED_OR_LOCKED,
                self::FOUND_IN_BLACKLIST,
                self::MALICIOUS_ACCESS,
                self::LOCKED_USER_ID,
                self::USERID_PWD_NO_MATCH,
            ],
            true
        );
    }

    public static function isNeededChangePassword(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::PWD_CHANGE_REQUIRED,
                self::TEMP_PWD_CHANGE_REQUIRED,
            ],
            true
        );
    }

    public static function isSuccess(): bool
    {
        return in_array(
            self::$errorCode,
            [
                self::SUCCESS,
                self::PROVISIONAL_ACTIVE_USER_CODE,
                self::DOC_UPLOAD_ONLY,
                self::MANUAL_DOC_UPLOAD,
                self::DUPLICATE_AUTHENTICATION_REQ_WARNING,
            ],
            true
        );
    }
}
