<?php
    @session_start();
    ob_start();
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 lblNamePage">Welcome to chat support!</h1>
</div>


<div class="row">
    <div class="col-4">
        <div class="list-group" id="chatList"></div>
        <!-- Item chat to clone  -->
        <a href="javascript:void(0);" class="list-group-item list-group-item-action d-none itemClone itemChatList">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1 cliName">Name</h5>
                <small class="txtm cliDate text-muted">3 days ago</small>
            </div>
            <p class="mb-1 cliMessage">Message.</p>
            <small class="txtm cliMail text-muted">Mail.</small>
        </a>
    </div>
    <div class="col-8 d-none" id="chatDetails">

        <div class="btn-group ms-2 mb-2" role="group">
            <button type="button" class="btn btn-outline-secondary" id="btnFinalizar"><i class="fa fa-power-off"></i> <text class="btnFinish">Finish chatting</text></button>
            <button type="button" class="btn btn-outline-secondary" id="btnMovechat" disabled="disabled"><i class="fa fa-bookmark-o"></i> <text class="btnMovetoFile">Move to file</text></button>
            <button type="button" class="btn btn-outline-secondary" id="btnFinalizechat"><i class="fa fa-envelope-open-o"></i> <text class="btnSenToMail">Finish and Send by email</text></button>            
        </div>                

        <div id="chatLog" class=""></div>

        <form class="row g-3">
            <div class="col-10">
                <label for="txtMessage" class="form-label labelMesage">New message</label>
                <textarea class="form-control" id="txtMessage" rows="3"></textarea>
            </div>
            <div class="col-2 pt-5">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="button" id="btnSend">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var chatActive = "",
        refreshLog = null;

    $(document).ready(function(){
        currentPage = "chat";
        loadChats();
        setInterval(loadChats, 2500);

        $(document).on("click", ".itemChatList", function(){
            if(refreshLog)
                clearInterval(refreshLog);

            chatActive = {
                _method: "GET",
                _file: $(this).data("chatlog"),
                _action: "getChat",
                _current: $(this).data("chatmail")
            };

            loadLog();
            refreshLog = setInterval(loadLog, 2500);

            $(".active").find(".txtm").addClass("text-muted");
            $(".active").removeClass("active");

            $(this).addClass("active");
            $(this).find(".txtm").removeClass("text-muted");
        });

        $("#btnSend").on("click", function(){
            sendMessage($("#txtMessage").val());
        });

        $("#btnFinalizar").on("click", function(){
            if (confirm(`Do you really want to end the chat with ${chatActive._current}?`)){
                $(".active").find(".txtm").addClass("text-muted");
                $(".active").removeClass("active");

                clearInterval(refreshLog);

                $("#chatLog").html("");
                $("#chatDetails").addClass("d-none");

                let dt = new Date(),
                    time = dt.getHours() + ":" + dt.getMinutes();

                let objData = {
                    _method: "POST",
                    _action: "closeChat",
                    _time: time,
                    _file: chatActive._file
                };

                $.post("../core/controllers/chatAdmin.php", objData);

                chatActive._file = "";                    
            }
        });

        $("#btnMovechat").on("click", function(){
            if (confirm(`Are you sure to move the chat to finished?`)){
                $(".active").find(".txtm").addClass("text-muted");
                $(".active").removeClass("active");

                clearInterval(refreshLog);

                $("#chatLog").html("");
                $("#chatDetails").addClass("d-none");

                let dt = new Date(),
                    time = dt.getHours() + ":" + dt.getMinutes();

                let objData = {
                    _method: "POST",
                    _action: "moveChat",
                    _file: chatActive._file
                };

                $.post("../core/controllers/chatAdmin.php", objData);

                chatActive._file = "";
                $("#btnMovechat").attr("disabled", "disabled");
            }
        });

        $("#btnFinalizechat").on("click", function(){
            if (confirm(`Do you really want to finish the chat with ${chatActive._current} and send the file by email?`)){
                $(".active").find(".txtm").addClass("text-muted");
                $(".active").removeClass("active");

                clearInterval(refreshLog);

                $("#chatLog").html("");
                $("#chatDetails").addClass("d-none");

                let dt = new Date(),
                    time = dt.getHours() + ":" + dt.getMinutes();

                let objData = {
                    _method: "POST",
                    _action: "sendChat",
                    _time: time,
                    _file: chatActive._file
                };

                $.post("../core/controllers/chatAdmin.php", objData);

                chatActive._file = "";                    
            }
        });
    });

    function loadChats(){
        let objData = {
            _method: "GET",
            _action: "getList"
        };

        $.post("../core/controllers/chatAdmin.php", objData, function(result) {
            if(result.length > 0){
                $("#chatList").html("");
                $.each( result, function( index, item){
                    let chat = $(".itemClone").clone();

                    chat.find(".cliName").html(item.name);
                    chat.find(".cliDate").html(item.date);
                    chat.find(".cliMessage").html(item.message);
                    chat.find(".cliMail").html(item.mail);

                    chat.data("chatlog", item.logFile);
                    chat.data("chatmail", item.mail);

                    chat.removeClass("itemClone d-none");

                    if(chatActive._file == item.logFile){
                        $(chat).addClass("active");
                        $(chat).find(".txtm").removeClass("text-muted");
                    }

                    $(chat).appendTo("#chatList");
                });
            }else{
                $("#chatList").html(`<p class="lead">No chats available at the moment</p>`);
            }
        });
    }

    function loadLog() {
        let oldscrollHeight = $("#chatLog")[0].scrollHeight - 20;

        $.post("../core/controllers/chatAdmin.php", chatActive, function(result) {
            $("#chatLog").html(result.html);
            $("#chatDetails").removeClass("d-none");

            let newscrollHeight = $("#chatLog")[0].scrollHeight - 20;
            if(newscrollHeight > oldscrollHeight)
                $("#chatLog").animate({ scrollTop: newscrollHeight }, 'normal');

            if(result.closed){
                $("#txtMessage").attr("disabled", "disabled");
                $("#btnSend").attr("disabled", "disabled");
                $("#btnMovechat").removeAttr("disabled");
                $("#btnFinalizar").attr("disabled", "disabled");
            }else{
                $("#txtMessage").removeAttr("disabled");
                $("#btnSend").removeAttr("disabled");
                $("#btnMovechat").attr("disabled", "disabled");
                $("#btnFinalizar").removeAttr("disabled");
            }
        });
    }

    function sendMessage(strMessage){
        let dt = new Date(),
            time = dt.getHours() + ":" + dt.getMinutes();

        let objData = {
            message: strMessage,
            _method: "POST",
            _time: time,
            _file: chatActive._file,
            _action: "responseChat",
        };

        $.post("../core/controllers/chatAdmin.php", objData);
        $("#txtMessage").val("");
        return false;
    }

    function changePageLang(myLang){
        $(".lblNamePage").html(myLang.pageTitle);
        $(".btnFinish").html(myLang.btnFinish);
        $(".btnMovetoFile").html(myLang.btnMovetoFile);
        $(".btnSenToMail").html(myLang.btnSenToMail);
        $(".labelMesage").html(myLang.labelMesage);
        $("#btnSend").html(myLang.btnSend);  
    }
</script>
<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>