<?php
return [
    "backend" => [
        "access" => [
            "roles" => [
                "already_exists" => "That role already exists. Please choose a different name.",
                "cant_delete_admin" => "You can not delete the Administrator role.",
                "create_error" => "There was a problem creating this role. Please try again.",
                "delete_error" => "There was a problem deleting this role. Please try again.",
                "has_users" => "You can not delete a role with associated users.",
                "needs_permission" => "You must select at least one permission for this role.",
                "not_found" => "That role does not exist.",
                "update_error" => "There was a problem updating this role. Please try again.",
            ],
            "permissions" => [
                "already_exists" => "That permission already exists. Please choose a different name.",
                "create_error" => "There was a problem creating this permission. Please try again.",
                "delete_error" => "There was a problem deleting this permission. Please try again.",
                "not_found" => "That permission does not exist.",
                "update_error" => "There was a problem updating this permission. Please try again.",
            ],
            "users" => [
                "cant_deactivate_self" => "You can not do that to yourself.",
                "cant_delete_self" => "You can not delete yourself.",
                "cant_delete_admin" => "You can not delete Admin.",
                "cant_delete_own_session" => "You can not delete your own session.",
                "cant_restore" => "This user is not deleted so it can not be restored.",
                "create_error" => "There was a problem creating this user. Please try again.",
                "delete_error" => "There was a problem deleting this user. Please try again.",
                "delete_first" => "This user must be deleted first before it can be destroyed permanently.",
                "email_error" => "That email address belongs to a different user.",
                "mark_error" => "There was a problem updating this user. Please try again.",
                "not_found" => "That user does not exist.",
                "restore_error" => "There was a problem restoring this user. Please try again.",
                "role_needed_create" => "You must choose at lease one role.",
                "role_needed" => "You must choose at least one role.",
                "session_wrong_driver" => "Your session driver must be set to database to use this feature.",
                "change_mismatch" => "That is not your old password.",
                "update_error" => "There was a problem updating this user. Please try again.",
                "update_password_error" => "There was a problem changing this users password. Please try again.",
            ],
        ],
        "pages" => [
            "already_exists" => "That Page already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Page. Please try again.",
            "delete_error" => "There was a problem deleting this Page. Please try again.",
            "not_found" => "That Page does not exist.",
            "update_error" => "There was a problem updating this Page. Please try again.",
        ],
        "blogcategories" => [
            "already_exists" => "That Blog Category already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Blog Category. Please try again.",
            "delete_error" => "There was a problem deleting this Blog Category. Please try again.",
            "not_found" => "That Blog Category does not exist.",
            "update_error" => "There was a problem updating this Blog Category. Please try again.",
        ],
        "blogtags" => [
            "already_exists" => "That Blog Tag already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Blog Tag. Please try again.",
            "delete_error" => "There was a problem deleting this Blog Tag. Please try again.",
            "not_found" => "That Blog Tag does not exist.",
            "update_error" => "There was a problem updating this Blog Tag. Please try again.",
        ],
        "person" => [
            "already_exists" => "That Person already exists. Please choose a different email.",
            "create_error" => "There was a problem creating this Person. Please try again.",
            "delete_error" => "There was a problem deleting this Person. Please try again.",
            "not_found" => "That Person does not exist.",
            "update_error" => "There was a problem updating this Person Tag. Please try again.",
        ],
        "settings" => [
            "update_error" => "There was a problem updating this Settings. Please try again.",
        ],
        "menus" => [
            "already_exists" => "That Menu already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Menu. Please try again.",
            "delete_error" => "There was a problem deleting this Menu. Please try again.",
            "not_found" => "That Menu does not exist.",
            "update_error" => "There was a problem updating this Menu. Please try again.",
        ],
        "modules" => [
            "already_exists" => "That Module already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Module. Please try again.",
            "delete_error" => "There was a problem deleting this Module. Please try again.",
            "not_found" => "That Module does not exist.",
            "update_error" => "There was a problem updating this Module. Please try again.",
        ],
        "patients" => [
            "already_exists" => "That Patient already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Patient. Please try again.",
            "delete_error" => "There was a problem deleting this Patient. Please try again.",
            "not_found" => "That Patient does not exist.",
            "update_error" => "There was a problem updating this Patient. Please try again.",
        ],
        "activepatientbalances" => [
            "already_exists" => "That ActivePatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this ActivePatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this ActivePatientBalance. Please try again.",
            "not_found" => "That ActivePatientBalance does not exist.",
            "update_error" => "There was a problem updating this ActivePatientBalance. Please try again.",
        ],
        "esrdpatients" => [
            "already_exists" => "That ESRDPatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this ESRDPatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this ESRDPatientBalance. Please try again.",
            "not_found" => "That ESRDPatientBalance does not exist.",
            "update_error" => "There was a problem updating this ESRDPatientBalance. Please try again.",
        ],
        "practices" => [
            "already_exists" => "That Practice already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Practice. Please try again.",
            "delete_error" => "There was a problem deleting this Practice. Please try again.",
            "not_found" => "That Practice does not exist.",
            "update_error" => "There was a problem updating this Practice. Please try again.",
        ],
        "providers" => [
            "already_exists" => "That Provider already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Provider. Please try again.",
            "delete_error" => "There was a problem deleting this Provider. Please try again.",
            "not_found" => "That Provider does not exist.",
            "update_error" => "There was a problem updating this Provider. Please try again.",
        ],
        "totalactivepatientbalances" => [
            "already_exists" => "That TotalActivePatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this TotalActivePatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this TotalActivePatientBalance. Please try again.",
            "not_found" => "That TotalActivePatientBalance does not exist.",
            "update_error" => "There was a problem updating this TotalActivePatientBalance. Please try again.",
        ],
        "esrdpatientbalances" => [
            "already_exists" => "That ESRDPatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this ESRDPatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this ESRDPatientBalance. Please try again.",
            "not_found" => "That ESRDPatientBalance does not exist.",
            "update_error" => "There was a problem updating this ESRDPatientBalance. Please try again.",
        ],
        "ckdpatientbalances" => [
            "already_exists" => "That CKDPatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this CKDPatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this CKDPatientBalance. Please try again.",
            "not_found" => "That CKDPatientBalance does not exist.",
            "update_error" => "There was a problem updating this CKDPatientBalance. Please try again.",
        ],
        "latepatientbalances" => [
            "already_exists" => "That LatePatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this LatePatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this LatePatientBalance. Please try again.",
            "not_found" => "That LatePatientBalance does not exist.",
            "update_error" => "There was a problem updating this LatePatientBalance. Please try again.",
        ],
        "analysisreports" => [
            "already_exists" => "That AnalysisReport already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this AnalysisReport. Please try again.",
            "delete_error" => "There was a problem deleting this AnalysisReport. Please try again.",
            "not_found" => "That AnalysisReport does not exist.",
            "update_error" => "There was a problem updating this AnalysisReport. Please try again.",
        ],
        "newckdpatientbalances" => [
            "already_exists" => "That NewCKDPatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this NewCKDPatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this NewCKDPatientBalance. Please try again.",
            "not_found" => "That NewCKDPatientBalance does not exist.",
            "update_error" => "There was a problem updating this NewCKDPatientBalance. Please try again.",
        ],
        "overduepatientbalances" => [
            "already_exists" => "That OverduePatientBalance already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this OverduePatientBalance. Please try again.",
            "delete_error" => "There was a problem deleting this OverduePatientBalance. Please try again.",
            "not_found" => "That OverduePatientBalance does not exist.",
            "update_error" => "There was a problem updating this OverduePatientBalance. Please try again.",
        ],
        "revenues" => [
            "already_exists" => "That Revenue already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Revenue. Please try again.",
            "delete_error" => "There was a problem deleting this Revenue. Please try again.",
            "not_found" => "That Revenue does not exist.",
            "update_error" => "There was a problem updating this Revenue. Please try again.",
        ],
        "physicianones" => [
            "already_exists" => "That Physician1 already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Physician1. Please try again.",
            "delete_error" => "There was a problem deleting this Physician1. Please try again.",
            "not_found" => "That Physician1 does not exist.",
            "update_error" => "There was a problem updating this Physician1. Please try again.",
        ],
        "physiciantwos" => [
            "already_exists" => "That PhysicianTwo already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this PhysicianTwo. Please try again.",
            "delete_error" => "There was a problem deleting this PhysicianTwo. Please try again.",
            "not_found" => "That PhysicianTwo does not exist.",
            "update_error" => "There was a problem updating this PhysicianTwo. Please try again.",
        ],
        "physicianthrees" => [
            "already_exists" => "That PhysicianThree already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this PhysicianThree. Please try again.",
            "delete_error" => "There was a problem deleting this PhysicianThree. Please try again.",
            "not_found" => "That PhysicianThree does not exist.",
            "update_error" => "There was a problem updating this PhysicianThree. Please try again.",
        ],
        "procedures" => [
            "already_exists" => "That Procedure already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Procedure. Please try again.",
            "delete_error" => "There was a problem deleting this Procedure. Please try again.",
            "not_found" => "That Procedure does not exist.",
            "update_error" => "There was a problem updating this Procedure. Please try again.",
        ],
        "prayers" => [
            "already_exists" => "That Prayer already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Prayer. Please try again.",
            "delete_error" => "There was a problem deleting this Prayer. Please try again.",
            "not_found" => "That Prayer does not exist.",
            "update_error" => "There was a problem updating this Prayer. Please try again.",
        ],
        "usermaintenences" => [
            "already_exists" => "That UserMaintenence already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this UserMaintenence. Please try again.",
            "delete_error" => "There was a problem deleting this UserMaintenence. Please try again.",
            "not_found" => "That UserMaintenence does not exist.",
            "update_error" => "There was a problem updating this UserMaintenence. Please try again.",
        ],
        "locationones" => [
            "already_exists" => "That LocationOne already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this LocationOne. Please try again.",
            "delete_error" => "There was a problem deleting this LocationOne. Please try again.",
            "not_found" => "That LocationOne does not exist.",
            "update_error" => "There was a problem updating this LocationOne. Please try again.",
        ],
        "locationtwos" => [
            "already_exists" => "That LocationTwo already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this LocationTwo. Please try again.",
            "delete_error" => "There was a problem deleting this LocationTwo. Please try again.",
            "not_found" => "That LocationTwo does not exist.",
            "update_error" => "There was a problem updating this LocationTwo. Please try again.",
        ],
        "locationthrees" => [
            "already_exists" => "That LocationThree already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this LocationThree. Please try again.",
            "delete_error" => "There was a problem deleting this LocationThree. Please try again.",
            "not_found" => "That LocationThree does not exist.",
            "update_error" => "There was a problem updating this LocationThree. Please try again.",
        ],
        "practicelocations" => [
            "already_exists" => "That PracticeLocation already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this PracticeLocation. Please try again.",
            "delete_error" => "There was a problem deleting this PracticeLocation. Please try again.",
            "not_found" => "That PracticeLocation does not exist.",
            "update_error" => "There was a problem updating this PracticeLocation. Please try again.",
        ],
        "practicedoctors" => [
            "already_exists" => "That PracticeDoctor already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this PracticeDoctor. Please try again.",
            "delete_error" => "There was a problem deleting this PracticeDoctor. Please try again.",
            "not_found" => "That PracticeDoctor does not exist.",
            "update_error" => "There was a problem updating this PracticeDoctor. Please try again.",
        ],
        "billingmanagers" => [
            "already_exists" => "That BillingManager already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this BillingManager. Please try again.",
            "delete_error" => "There was a problem deleting this BillingManager. Please try again.",
            "not_found" => "That BillingManager does not exist.",
            "update_error" => "There was a problem updating this BillingManager. Please try again.",
        ],
        "practiceusers" => [
            "already_exists" => "That PracticeUser already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this PracticeUser. Please try again.",
            "delete_error" => "There was a problem deleting this PracticeUser. Please try again.",
            "not_found" => "That PracticeUser does not exist.",
            "update_error" => "There was a problem updating this PracticeUser. Please try again.",
        ],
        "profiles" => [
            "already_exists" => "That Profile already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Profile. Please try again.",
            "delete_error" => "There was a problem deleting this Profile. Please try again.",
            "not_found" => "That Profile does not exist.",
            "update_error" => "There was a problem updating this Profile. Please try again.",
        ],
        "agingsummaries" => [
            "already_exists" => "That AgingSummary already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this AgingSummary. Please try again.",
            "delete_error" => "There was a problem deleting this AgingSummary. Please try again.",
            "not_found" => "That AgingSummary does not exist.",
            "update_error" => "There was a problem updating this AgingSummary. Please try again.",
        ],
        "cptcodes" => [
            "already_exists" => "That CptCode already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this CptCode. Please try again.",
            "delete_error" => "There was a problem deleting this CptCode. Please try again.",
            "not_found" => "That CptCode does not exist.",
            "update_error" => "There was a problem updating this CptCode. Please try again.",
        ],
        "cptcodeinsuranceprices" => [
            "already_exists" => "That CptCodeInsurancePrice already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this CptCodeInsurancePrice. Please try again.",
            "delete_error" => "There was a problem deleting this CptCodeInsurancePrice. Please try again.",
            "not_found" => "That CptCodeInsurancePrice does not exist.",
            "update_error" => "There was a problem updating this CptCodeInsurancePrice. Please try again.",
        ],
        "payers" => [
            "already_exists" => "That Payer already exists. Please choose a different name.",
            "create_error" => "There was a problem creating this Payer. Please try again.",
            "delete_error" => "There was a problem deleting this Payer. Please try again.",
            "not_found" => "That Payer does not exist.",
            "update_error" => "There was a problem updating this Payer. Please try again.",
        ],
    ],
    "frontend" => [
        "auth" => [
            "confirmation" => [
                "already_confirmed" => "Your account is already confirmed.",
                "confirm" => "Confirm your account!",
                "created_confirm" => "Your account was successfully created. We have sent you an e-mail to confirm your account.",
                "created_pending" => "Your account was successfully created and is pending approval. An e-mail will be sent when your account is approved.",
                "mismatch" => "Your confirmation code does not match.",
                "not_found" => "That confirmation code does not exist.",
                "resend" => "Your account is not confirmed. Please click the confirmation link in your e-mail, or <a href=http://127.0.0.1:8000/account/confirm/resend/:user_id>click here</a> to resend the confirmation e-mail.",
                "success" => "Your account has been successfully confirmed!",
                "resent" => "A new confirmation e-mail has been sent to the address on file.",
                "pass_change" => "Your password has been changed successfully",
            ],
            "deactivated" => "Your account has been deactivated.",
            "email_taken" => "That e-mail address is already taken.",
            "password" => [
                "change_mismatch" => "That is not your old password.",
                "reset_problem" => "That Reset Password Link is old!!",
                "reset_password" => "Use the new password !!",
                "old_password" => "The password is old.kindly change password you never use before"

            ],
            "registration_disabled" => "Registration is currently closed.",
            "add_billing_manager" => "Billing manager added"
        ],
    ],
];