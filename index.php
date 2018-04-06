<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="https://cdn.webix.com/edge/webix.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="src/js/jquery.min.js" type="text/javascript"></script>
        <script src="src/js/webix.js" type="text/javascript"></script>
        <style>
            .back_panel  {
                background-color: #061630;
            }
            .message {
                color: red;
            }
        </style>
    </head>
    <body>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function(){
                var div = document.getElementById("dom-target");
                var myData = <?php
                              if (isset($_GET['fail'])) {
                                if ($_GET['fail'] == 1){
                                  echo "'Password mismatch or User already exists'";
                                }
                                else if ($_GET['fail'] == 2){
                                  echo "'Password, and Username must be at least 3 characters long'";
                                }
                              }
                              else {echo "'NO FAIL'";}
                             ?>;
                webix.ui({
                    view:"layout",
                    height:'auto',
                    width:'auto',
                    css:"back_panel",
                    rows:[
                        { gravity:0.3 },
                        { cols:[
                             {  },
                             { view:"form", 
                               id:"log_form",
                               gravity:0.4,
                               width:400,
                               elements:[
                                   { view:"template", type:"header", template:"Online Text Editor" },
                                   { view:"text", label:"Username", name:"username", labelWidth:100, required:true},
                                   { view:"text", type:"Password", label:"Password", name:"password", labelWidth:100, required:true},
                                   { margin:2, cols:[
                                       { view:"button", id:"help_button", value:"Help"},
                                       { view:"button", id:"login_submit", value:"Login" , type:"form"}
                                   ]}
                               ]
                             },
                             {  }
                        ]},
                        { gravity:0.3 }
                    ]
                });
                var log_form = $$("log_form");

                var help_popup = webix.ui({
                    view:"popup",
                    id:"my_popup",
                    position:"top",
                    body:{
                        rows:[
                            { view:"template", type:"header", template:"Help"},
                            { view:"template", template:"Unlike your usual Web Application, you don't need to register! crazy right?"},
                            { view:"button", value:"Ok", id:"help_ok", width:250, position:'center'},

                        ]
                    }
                });

                var help_event = $$("help_button").attachEvent("onItemClick", function(){
                  help_popup.show();
                });

                var ok_event = $$("help_ok").attachEvent("onItemClick", function(){
                  help_popup.hide();
                });

                var login_event = $$("login_submit").attachEvent("onItemClick", function(){
                  webix.send("login.php", log_form.getValues());
                });
                if (myData != 'NO FAIL') {
                  var id = $$("log_form").addView({
                      css:"message", view:"label", label:myData, align:'center'
                  }, 1);
                }
            });
        </script>
    </body>
</html>