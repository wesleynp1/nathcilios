@if (Session::has("message"))
    <script>
        alert('{{Session::get("message")}}'.replace(/&quot;/g,'"'));
    </script>
@endif