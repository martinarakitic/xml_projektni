<?php
    $login = simplexml_load_file('korisnici.xml');
    $sadrzaj = simplexml_load_file('auti.xml');
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Naslovna</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center">
        <form action="" method="post">
            <label for="korisnickoime">Korisničko ime:</label><br>
            <input type="text" name="korisnickoime" id="korisnickoime"><br>
            <label for="lozinka">Lozinka:</label><br>
            <input type="password" name="lozinka" id="lozinka"><br>
            <input type="submit" value="LOGIN">
        </form>
    </div>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['korisnickoime']) && isset($_POST['lozinka'])){
            $kor_ime = $_POST['korisnickoime'];
            $loz = $_POST['lozinka'];
            $uspjesna_prijava = false; 

            foreach($login->korisnik as $kor){
                $korime = (string) $kor->korisnicko_ime;
                $lozinka = (string) $kor->lozinka;
                $prava = (int) $kor->razina_prava;

                if($korime == $kor_ime && $lozinka == $loz && $prava == 1){
                    echo "<p class='text-center text-success'>Uspješna prijava</p>";
                    $uspjesna_prijava = true; 
                    break;
                }
            }
            if (!$uspjesna_prijava) {
                echo "<p class='text-center text-danger'>Neuspješna prijava. Provjerite korisničko ime i lozinku.</p>";
            }
        }
    }

    if(isset($uspjesna_prijava) && $uspjesna_prijava == true){
        echo "<div class='container'>
                <table class='table'>
                    <thead>
                        <tr class='text-center'>
                            <th>Marka</th>
                            <th>Model</th>
                            <th>Tip</th>
                            <th>Godina proizvodnje</th>
                            <th>Snaga motora</th>
                            <th>Vrsta motora</th>
                            <th>Mjenjač</th>
                        </tr>
                    </thead>
                    <tbody>";
                    foreach($sadrzaj->auto as  $auto) {
                        echo "<tr class='text-center'>
                        <td>{$auto->marka}</td>
                        <td>{$auto->model}</td>
                        <td>{$auto->tip}</td>
                        <td>{$auto->godina_proizvodnje}</td>
                        <td>{$auto->motor->snaga_motora}</td>
                        <td>{$auto->motor->vrsta_motora}</td>
                        <td >{$auto->mijenjac}</td>
                        </tr>";
                    }
                    echo "</tbody>
                </table>
            </div>";
    }
    ?>
</body>
</html>
