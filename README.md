# hidenric

This extension includes a custom permission named "hidenric" which will hide NRIC record in contact summary page and prevent editing NRIC field from the user. We can choose desired WordPress user roles to do so. 

## Getting Started

“Administer >> Users and Permissions >> Permissions (Access Control) >> WordPress Permissions”

Press “Ctrl” and “F” on the keyboard simultaneously and search the word “administer”
![Alt text](images/image3.png)

(* FIXME: 
    1. Install and enable "hidenric" extension in your CiviCRM.
    2. Create a new contact, also fill in External ID and Save.
    3. Go to "Administer >> Users and Permissions >> Access Control Lists >> WordPress Permissions".
    4. Find "CiviCRM: hide nric" and tick any WordPress User Role that you want to hide from, and Save.
    5. On navigation bar, hover and click "Users >> Add new user" and Create a new user according to the role that you choose in step3.
    6. After creating user, go back to WordPress Permissions and tick the below permissions for the WordPress Role you choose
        - CiviCRM: view all contacts
        - CiviCRM: edit all contacts
        - CiviCRM: access CiviCRM backend and API
        and Save.
    7. Open new Incognito window and open your local WordPress.
    8. Log in as a WordPress User Role that you chose.
    9. Find the contact name you created, and you can see External ID as "*********" in contact summary page and when you click 'edit', you will  see NRIC field hidden.
    10. When you check Administrator side, you can see NRIC record. You can also test for other WordPress Roles.
 *)

## Don'ts

(* FIXME *)

This is an [extension for CiviCRM](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/), licensed under [AGPL-3.0](LICENSE.txt).