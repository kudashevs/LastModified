## LastModified

MODx Revolution plugin which handle request If-Modified-Since and return Last-Modified header  
and 304 response code if necessary (more info and site check on https://last-modified.com/en/)

After installation use System settings lastmodified namespace to set preferable settings values. 


### Available system settings (namespace lastmodified):

* maxage – set value of max-age Cache-control header in seconds, default is 3600.
* expires – set value of Expires header current time offset in seconds, efault is 3600.