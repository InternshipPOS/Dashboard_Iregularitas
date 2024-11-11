<?php
include 'config.php'; // Include your database configuration

// Ambil data regional
$queryRegional = "SELECT distinct regional FROM ref_kcu_kc";
$resultRegional = mysqli_query($koneksi, $queryRegional);

// Ambil data kantor
$queryKantor = "SELECT distinct nama_kantor FROM ref_kcu_kc";
$resultKantor = mysqli_query($koneksi, $queryKantor);
?>
<form action="proses_pilihan.php" method="POST">
    <!-- Dropdown untuk memilih regional -->
    <label for="regional">Pilih Regional:</label>
    <select name="regional" id="regional">
        <option value="">-- Pilih Regional --</option>
        <?php
        // Loop data regional untuk opsi dropdown
        while ($rowRegional = mysqli_fetch_assoc($resultRegional)) {
            echo "<option value='" . $rowRegional['id'] . "'>" . $rowRegional['nama_regional'] . "</option>";
        }
        ?>
    </select>

    <!-- Dropdown untuk memilih kantor -->
    <label for="kantor">Pilih Kantor:</label>
    <select name="kantor" id="kantor">
        <option value="">-- Pilih Kantor --</option>
        <?php
        // Loop data kantor untuk opsi dropdown
        while ($rowKantor = mysqli_fetch_assoc($resultKantor)) {
            echo "<option value='" . $rowKantor['id'] . "' data-regional='" . $rowKantor['regional_id'] . "'>" . $rowKantor['nama_kantor'] . "</option>";
        }
        ?>
    </select>

    <button type="submit">Submit</button>
</form>
<script>
document.getElementById('regional').addEventListener('change', function () {
    const regionalId = this.value;
    const kantorDropdown = document.getElementById('kantor');

    // Sembunyikan semua kantor terlebih dahulu
    for (const option of kantorDropdown.options) {
        option.style.display = 'none';
    }

    // Tampilkan kantor yang sesuai dengan regional yang dipilih
    for (const option of kantorDropdown.options) {
        if (option.getAttribute('data-regional') === regionalId || option.value === "") {
            option.style.display = 'block';
        }
    }

    // Set opsi pertama sebagai pilihan default
    kantorDropdown.value = "";
});
// proses_pilihan.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $regional = $_POST['regional'];
    $kantor = $_POST['kantor'];

    // Lakukan proses sesuai kebutuhan, seperti menyimpan ke database atau menampilkan data
    echo "Regional ID: $regional<br>";
    echo "Kantor ID: $kantor<br>";
}
</script>


<!-- Button to Monitoring Page -->
<a href="monitoring.php" class="btn btn-success mb-3">Go to Monitoring</a>