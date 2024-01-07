    <!-- CHATBOX -->
    <div class="chatbox-container">
        <div class="chatbox-header">
            <div class="p1">
                <back id="backtoMain"><ion-icon name="arrow-back-outline" style="color: #808080;"></ion-icon></back>
                <img src="images/john-doe.jpg" alt="">
                <div class="name">
                    <h1 id="profile_name"><!-- Allan Soriano--></h1>
                    <span>Online</span>
                </div>
            </div>
            <div class="header-addons">
                <ion-icon name="videocam"></ion-icon>
                <ion-icon name="call"></ion-icon>
                <ion-icon name="ellipsis-vertical-outline" style="color: #555555;"></ion-icon>
            </div>
        </div>
        <div class="chatbox-content" id="chatbox-content">
            <!-- <empty>Start a Conversation...</empty> -->
            <!-- <div class="message-row receive"><span>low</span></div>
            <div class="message-row"><span>lorem</span></div> -->
        </div>
        <div class="chatbox-footer">
            <span class="emj"><ion-icon name="happy"></ion-icon></span>
            <textarea id="getMessage" cols="30" rows="10" placeholder="Message"></textarea>
            <span class="msg-addons">
                <ion-icon name="attach"></ion-icon>
                <ion-icon name="camera"></ion-icon>
            </span>
        </div>
    </div>

    <id_loader id="chatbox_id_load" class="id_loader"></id_loader>
    
    <script src="scripts/chatbox.js"></script>