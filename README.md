## LastModified

MODx Revolution plugin which handle request If-Modified-Since and return Last-Modified header  
and 304 response code if necessary (more info and site check on https://last-modified.com/en/)

After installation use System settings lastmodified namespace to set preferable settings values. 


### Available system settings (namespace lastmodified):

* response - set value of Cache-control response directive, available values: "private", "public".
* maxage – set value of Cache-control max-age directive in seconds, default is 3600.
* expires – set value of Expires header current time offset in seconds, default is 3600.
* update_parent - updates last editing date of parent resource to reacquire its content. Default false.
* update_level - set nested level from current resource and up for parent resources dates update. Default 1.
* update_start - update last editing date for start page too on every resource change. Default false.
* prevent_authorized - prevent If-Modified-Since handling for authorized users. Default true.
* prevent_session - prevent If-Modified-Since handling if any of listed values (comma separated) was founded in session variables names. Default minishop2.