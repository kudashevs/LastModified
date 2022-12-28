## LastModified

A MODx Revolution plugin which handles the If-Modified-Since request header and returns the Last-Modified response
header with the 304 response code when it is necessary (more info and site check on https://last-modified.com/en/)

After the installation process, please visit `System Settings`, choose a `lastmodified` namespace, and set the desired settings.

### Available system settings (namespace `lastmodified`):

* response - specifies a value of the Cache-control response directive, available options: "private", "public".
* maxage – specifies a value of the Cache-control max-age directive in seconds, default is 3600.
* expires – specifies a value of the Expires header as an offset from the current time in seconds, default is 3600.
* update_parent - updates the last editing date of the parent resource to show that it has been updated too. Default false.
* update_level - sets a nested level from the current resource and up to update the last editing date. Default 1.
* update_start - updates the last editing date of the start page on a resource change. Default false.
* prevent_authorized - prevents If-Modified-Since header handling for authorized users. Default true.
* prevent_session - prevents If-Modified-Since header handling when any of the values (comma-separated list) occur in session names. Default minishop2.
* exclude - prevents If-Modified-Since header handling for any of listed document ids (comma-separated list). Empty by default.
