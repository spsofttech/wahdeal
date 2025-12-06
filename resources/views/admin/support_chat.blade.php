@extends('admin.layouts.app')

@section('title', 'Support Chat')

<style>
body {
    font-family: Arial, sans-serif;
    /* background: #f3f7fb;
      padding: 40px; */
    margin: 0;
}

.chat-wrapper {
    /* max-width: 600px; */
    margin: auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

h1 {
    font-size: 24px;
    margin: 0;
}

.dropdown select {
    padding: 10px;
    font-size: 16px;
}

.chat-display {
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #f9f9f9;
    height: 300px;
    overflow-y: auto;
    padding: 10px;
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.message {
    padding: 10px 14px;
    border-radius: 16px;
    max-width: 80%;
    word-wrap: break-word;
}

.user-message {
    align-self: flex-end;
    background-color: #dcf8c6;
}

.other-message {
    align-self: flex-start;
    background-color: #e5e5ea;
}

.chat-box {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

textarea {
    flex: 1;
    height: 40px;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: none;
    overflow-y: auto;
    line-height: 1.5;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

textarea::-webkit-scrollbar {
    display: none !important;
}

.chat-box input[type="file"] {
    font-size: 16px;
    cursor: pointer;
    width: 30px;
}

button {
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    background-color: #4caf50;
    color: white;
    border-radius: 100% !important;
}

button i {
    font-size: 16px;
}

.chat-file-preview img {
    max-width: 100px;
    margin-top: 8px;
    border-radius: 6px;
}

.chat-file-name {
    font-size: 14px;
    margin-top: 5px;
    color: #333;
}

.upload-icon-label {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: #ddd;
    border-radius: 50%;
    cursor: pointer;
    margin-top: 8px
}

.upload-icon-label i {
    color: #555;
}

.chat-box input[type="file"] {
    display: none;
}

.user-icon {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background-color: #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 20px;
}

.wa-chat-messages {
    flex: 1;
    padding: 24px 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.wa-chat-messages::-webkit-scrollbar {
    display: none !important;
}

.wa-msg {
    max-width: 60%;
    padding: 10px 16px;
    border-radius: 16px;
    font-size: 15px;
    line-height: 1.5;
    word-break: break-word;
    background: #fff;
    align-self: flex-start;
    box-shadow: 0 1px 2px #0001;
    position: relative;
}

.wa-msg.me {
    background: #dcf8c6;
    align-self: flex-end;
}

.wa-msg-time {
    font-size: 11px;
    color: #888;
    margin-left: 8px;
}
</style>

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Support Chat</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Support Chat</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div>

            <div class="chat-wrapper">
                @php
                $status = $st->status ?? 0;
                @endphp
                <!-- Header -->
                <div class="row">
                    <h1>Comment</h1>
                    <div class="dropdown">
                        <select name="category" onchange="active_deactive('{{$st->id}}', this.value)">
                            <option value="" selected disabled>----Select Status----</option>
                            <option value="0" @if($status===0) selected @endif @if($status===1 || $status===2) disabled
                                @endif>
                                Pending
                            </option>

                            <option value="1" @if($status===1) selected @endif @if($status===2) disabled @endif>
                                Active
                            </option>

                            <option value="2" @if($status===2) selected @endif>
                                Closed
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div class="chat-display" id="chatDisplay">
                    <div class="wa-chat-messages">
                        @foreach($chat as $val)
                        @php
                        @endphp
                        <div class="wa-msg @if($val['user_id'] == 0) me @endif">

                            @php
                            $comment = $val['comment'];
                            $fileExtension = pathinfo($comment, PATHINFO_EXTENSION);
                            $file = asset('uploads/support_chat/' . $comment);
                            @endphp

                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ $file }}" alt="Image"
                                style="max-width: 10%; height: auto; border-radius: 5px;">
                            @elseif(in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                            <video controls style="max-width: 30%; height:10%;">
                                <source src="{{ $file }}" type="video/{{ $fileExtension }}">
                                Your browser does not support the video tag.
                            </video>
                            @elseif(in_array($fileExtension, ['mp3', 'wav', 'ogg']))
                            <a href="{{ $file }}" target="_blank">{{ $comment }}</a>
                            @elseif(in_array($fileExtension, ['pdf', 'docx']))
                            <a href="{{ $file }}" target="_blank">{{ $comment }}</a>
                            @else
                            {{ $comment }}
                            @endif


                            <span
                                class="wa-msg-time">{{ \Carbon\Carbon::parse($val['created_at'])->format('d M Y, h:i A') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Chat Input -->
                <form name="form" action="#" id="registerForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$st->id}}">
                    <div class="chat-box">
                        <textarea id="chatInput" name="message" placeholder="Write your comment here..."></textarea>

                        <!-- File Upload Icon -->
                        <label class="upload-icon-label" for="fileInput">
                            <i class="fas fa-paperclip"></i>
                        </label>
                        <input type="file" id="fileInput" name="file" style="display: none;" />

                        <!-- Send Button -->
                        @if($status != '2')
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        @endif
                    </div>
                </form>
            </div>

            <section class="content">
                <div class="container-fluid">
                </div>
            </section>
        </div>
</section>
@endsection

@section('scripts')
<script>

</script>

<script>
const fileInput = document.getElementById("fileInput");
const chatInput = document.getElementById("chatInput");

fileInput.addEventListener("change", () => {
    const file = fileInput.files[0];
    if (file) {
        chatInput.value += `📎 ${file.name}\n`;
    }
});



function active_deactive(id, val) {
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{ route('admin.ticket_status_change') }}",
        type: "POST",
        data: {
            _token: csrfToken,
            id: id,
            value: val
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });
}
</script>

<script>
$('#registerForm').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    // Send the AJAX request
    $.ajax({
        url: '{{route("admin.insert_support_comment")}}',
        type: 'POST',
        data: formData,
        processData: false, // Don't process data
        contentType: false,
        success: function(response) {
            if (response.status == 'success') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    toast: true,
                    timer: 5000
                });
                location.reload();
            }
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            $("#email-error").html(errors.email);
        }
    });
});
</script>
@endsection