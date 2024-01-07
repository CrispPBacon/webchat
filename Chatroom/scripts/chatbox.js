$(document).ready(function(){

    $('#backtoMain').click(function() {
        // console.log("WELCOME");
        $.ajax({
            url: 'ajax/chatmain.php',
            success: function(data) {
                const responseData = data;
                $.ajax({
                    url: 'index.php',
                    success: function() {
                        $('body').html(responseData);
                    }
                });
            }
        });
    });
    

    $('#getMessage').on('keydown', function(event){
        if (($('#getMessage').val()).trim().length) {
            if(event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                const msg = $('#getMessage').val().trim()
                const friend_id = $('#id_loader').val();
                $.ajax({
                    url: 'backend/chat/chatbox_backend.php',
                    method: 'post',
                    data: {request: 'send_message', friend_id: friend_id, message: msg},
                    success: function() {
                        $('#getMessage').val('');
                    }
                });
            }
        }
    });

    function isJSON(str) {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            return false;
        }
    }

    const message_interval = setInterval(fetch_messages, 500);
    let lastRow = 0;
    function fetch_messages() {

        const val = $('#id_loader').val()
        if (val == undefined) {
            clearInterval(message_interval);
            return
        }
        $.ajax({
            url: 'backend/chat/chatbox_backend.php',
            method: 'post',
            data: { request: 'fetch_chats_content', friend_id: val, lastRow: lastRow},
            success: function(data) {
                if (data == 'Empty') {
                    $('#chatbox-content').html('<empty>Start a Conversation...</empty>');
                }
                if (!isJSON(data)) {
                    return
                }

                const wrapData = JSON.parse(data);
                const userId = wrapData['userid'];
                const currentRow = wrapData['currentRow'];
                
                if (currentRow > lastRow) {
                    lastRow = currentRow;
                    let contents = '';
                    for(const detail of wrapData['details']) {
                        const sender = detail['from_id'];
                        let state = '';
                        if (!(sender == userId)) {
                            state = 'receive';
                        }
                        contents += `<div class="message-row ${state}"><span>${detail['message']}</span></div>`;
                    }        

                    if (!(wrapData['details'][0]['from_id'] == userId)) {
                        $.ajax({
                            url: 'backend/chat/chatmain_backend.php',
                            method: 'post',
                            data: { request: 'set_read_status', friend_id: val },
                        });
                    }
                    
                    $('#chatbox-content').html(contents);
                }
            }
        });

    }
});