<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Inscription Maxit Sénégal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maxitOrange: "#FF7900",
                        maxitOrangeDark: "#FF6600",
                        maxitGray: "#F5F7FA",
                    },
                    boxShadow: {
                        maxit: "0 8px 32px 0 rgba(255,121,0,0.10)",
                    },
                },
            },
        };
    </script>
</head>

<body
    class="bg-gradient-to-br from-maxitOrange/80 via-maxitGray to-maxitOrangeDark/70 min-h-screen flex items-center justify-center"
>
<?php
require_once(__DIR__ . "/partial/header.html.php");
?>

<main class="p-6">
    <?php echo $content; ?>
</main>

</html>
