<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Opening WahDeal...</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
      const appUrl = "{{ $appUrl }}";
      const webUrl = "{{ $webUrl }}";

      // Try to open app
      window.location.href = appUrl;

      // If app not installed → fallback after 2s
      setTimeout(() => {
        window.location.href = webUrl;
      }, 2000);
    });
    </script>
</head>

<body>
    <p>Opening WahDeal App...</p>
</body>

</html>