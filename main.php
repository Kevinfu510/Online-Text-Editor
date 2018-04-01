<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="https://cdn.webix.com/edge/webix.css" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="src/js/jquery.min.js" type="text/javascript"></script>
        <script src="src/js/webix.js" type="text/javascript"></script>
    </head>
    <body>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $.getJSON('/addemp/Online Text Editor/retrieve_files.php', function(jsonData) {
                    if (jsonData == "403") {
                        var header_title = "403 Unauthorized Access"
                        webix.ui({
                            rows:[
                                { view:"template", type:"header", template: header_title },
                                { view:"template", template: "Either your session has timed out, or you tried to do something that might have broken the delicate balance of the universe. </br> Please don't do that again... okay? Thanks~ </br> - Kevin"}
                            ]
                        });
                    }
                    else {
                        var obj = JSON.stringify(jsonData);
                        var header_title = '<?php if (isset($_SESSION['session_id'])) {echo $_SESSION['session_id'];}?>'
                        webix.ui({
                            rows:[
                                { cols:[
                                    {view:"template", type:"header", template: header_title, gravity:0.8},
                                    {view:"button", id:"logout", value: 'Logout', gravity:0.2, type:"danger"}
                                    ]
                                },
                                { cols:[
                                    { rows:[
                                        {view:"tree", id:"MyTree", data:obj, gravity:0.65, select:true},
                                        {view:"button", id:"new", value:"New", type:'form'},
                                        {view:"button", id:"save", value:"Save"},
                                        {view:"button", id:"delete", value:"Delete", type:"danger"}
                                      ], gravity:0.2
                                    },
                                    { view:"textarea", id:"MyText", label:"", height:"auto", value: "", gravity:0.75}
                                  ]
                                }
                            ]
                        });
                        $$('MyText').disable();
                        var create_popup = webix.ui({
                            view:"popup",
                            id:"my_popup",
                            position:"center",
                            body:{
                                rows:[
                                    { view:"template", type:"header", template:"New Note"},
                                    { view:"text", id:"name", value:"New Note"},
                                    { view:"button", id:"create", value:"Create"},
                                ]
                            }
                        });
                        var myEvent = $$("MyTree").attachEvent("onAfterSelect", function(){
                            var item = $$("MyTree").getSelectedItem();
                            $$("MyText").setValue(item['content']);
                            $$('MyText').enable();
                        });

                        var new_event = $$("new").attachEvent("onItemClick", function(){
                            create_popup.show();
                        });

                        var create_event = $$("create").attachEvent("onItemClick", function(){
                            var name = $$("name").getValue();
                            $.ajax({
                                data: 'name=' + name,
                                url: 'new.php',
                                method: 'POST',
                                datatype: 'json',
                                success: function() {
                                    refresh_tree();
                                    create_popup.hide();
                                },
                                error: function() {
                                    console.log('Something bad happened');
                                }
                            });
                        });

                        var delete_button = $$("delete").attachEvent("onItemClick", function(){
                            var item = $$("MyTree").getSelectedItem();
                            $.ajax({
                                data: 'id=' + item['id'],
                                url: 'delete.php',
                                method: 'POST',
                                datatype: 'json',
                                success: function() {
                                    var tree = $$('MyTree');
                                    var nodeId = tree.getSelectedId();
                                    tree.remove(nodeId);
                                    refresh_tree();
                                },
                                error: function() {
                                    console.log('Something bad happened');
                                }
                            });
                        });
                        var logout_button = $$("logout").attachEvent("onItemClick", function(){
                            $.ajax({
                                url: 'logout.php',
                                method: 'GET',
                                success: function() {
                                    console.log("Logout");
                                    window.location = "/addemp/Online Text Editor/index.php";
                                },
                                error: function() {
                                    console.log('Something bad happened');
                                }
                            });
                        });
                        var save_button = $$("save").attachEvent("onItemClick", function(){
                            var item = $$("MyTree").getSelectedItem();
                            var text = $$("MyText").getValue();
                            $.ajax({
                                data: 'id=' + item['id'] + '&content=' + text,
                                url: 'update.php',
                                method: 'POST',
                                datatype: 'json',
                                success: function() {
                                    var tree = $$('MyTree');
                                    var nodeId = tree.getSelectedId();
                                    tree.remove(nodeId);
                                    refresh_tree();                                    
                                },
                                error: function() {
                                    console.log('Something bad happened');
                                }
                            });
                        });
                        function refresh_tree() {
                            $.getJSON('/addemp/Online Text Editor/retrieve_files.php', function(jsonData) {
                                var obj = JSON.stringify(jsonData);
                                $$('MyTree').define("data", obj);
                                $$('MyText').disable();
                            });
                        }
                    }
                });
            });
        </script>
    </body>
</html>