var  netatmo  = require('netatmo');

var  auth  = {
    " client_id " : "5df8a4d54009037c7709dec9" ,
    " client_secret " : "BmXyO6DXU7yr0Yo2sJ8UGasg9kAgom" ,
    " nom d'utilisateur " : "peterson.rostain@gmail.com" ,
    " mot de passe " : "mcA1AI45$ycq" ,
} ;

var api = new netatmo(auth);


api.getStationsData(function(err, devices) {
    console.log(devices);
});