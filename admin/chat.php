<?php
    @session_start();
    ob_start();
?>

<div class="container">
        <nav class="navbar navbar-light bg-light mb-5">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1 pageTitle">Welcome to chat support!</span>
            </div>
        </nav>

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
                    <button type="button" class="btn btn-outline-secondary changeLang">Español</button>
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
    </div>

<?php
    $content = ob_get_contents();
    ob_end_clean();

    include("index.php");
?>