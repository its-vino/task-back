# example-ferries-server

This is a very simple "server-side" component of
a basic distributed system, to assist with travel planning
amongst the Southern Gulf Islands. The data supplied is old, so don't
rely on it for a current trip!

This is the server, so it contains the actual data.
This webapp was built from the example-ferries-standalone project, and then 
tailored per the plan outlined there.

Specifically, this webapp provides two server endpoints: one for REST
requests for port information, and the other an XML-RPC server
which exposes sailings searching functionality.

The relevant pieces in this webapp:

    /application
        /config
            autoload.php ... add restful package
        /controllers
            Welcome.php ... "go away"
        /models
            Ferryschedule.php ... the original model
        /packages
            /restful       ... see below
                ....
    /data
        ferryschedule.dtd
        ferryschedule.xml

This incorporates a [packaging](https://github.com/jedi-academy/package-restful) 
of an older version of Phil Sturgeon's REST server,
which has now been [superceded](https://github.com/chriskacerguis/codeigniter-restserver).
Incorporating that will be the next iteration of this example, and won't happen this term.

##Deployment

This app is self-contained. Extract it somewhere suitable, and map
a virtual host (eg <code>server.local</code>) to its <code>public</code> folder.

Modify <code>controllers/Welcome.php</code> to reference the hostname you used
when you setup your server app.

CAUTION: There is an issue with the sailings lookup, using XML-RPC,
I will hunt it down, but wanted to share the app as it sits, because of the REST
service, which works.