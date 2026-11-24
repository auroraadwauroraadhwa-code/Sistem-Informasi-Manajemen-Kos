
<?php
session_start();

// Memanggil semua class
require_once 'Classes/Pengguna.php';
require_once 'Classes/pemilik.php';
require_once 'Classes/penyewa.php';
require_once 'Classes/kos.php';
require_once 'Classes/kamar.php';
require_once 'Classes/fasilitas.php';
require_once 'Classes/pembayaran.php';

// Pengaturan data dan field
$config = [
    'pengguna' => [
        'judul' => 'Data Pengguna',
        'class' => 'Pengguna',
        'fields' => [
            'nama' => 'Nama',
            'email' => 'Email',
            'no_hp' => 'Nomor HP'
        ]
    ],
    'pemilik' => [
        'judul' => 'Data Pemilik',
        'class' => 'Pemilik',
        'fields' => [
            'id' => 'ID Pemilik',
            'nama' => 'Nama',
            'email' => 'Email',
            'no_hp' => 'Nomor HP'
        ]
    ],
    'penyewa' => [
        'judul' => 'Data Penyewa',
        'class' => 'Penyewa',
        'fields' => [
            'id' => 'ID Penyewa',
            'nama' => 'Nama',
            'email' => 'Email',
            'no_hp' => 'Nomor HP',
            'nomor_kamar' => 'Nomor Kamar'
        ]
    ],
    'kos' => [
        'judul' => 'Data Kos',
        'class' => 'Kos',
        'fields' => [
            'nama_kos' => 'Nama Kos',
            'alamat' => 'Alamat'
        ]
    ],
    'kamar' => [
        'judul' => 'Data Kamar',
        'class' => 'Kamar',
        'fields' => [
            'nomor' => 'Nomor Kamar',
            'harga' => 'Harga',
            'status' => 'Status'
        ]
    ],
    'fasilitas' => [
        'judul' => 'Data Fasilitas',
        'class' => 'Fasilitas',
        'fields' => [
            'nama' => 'Nama Fasilitas',
            'keterangan' => 'Keterangan'
        ]
    ],
    'pembayaran' => [
        'judul' => 'Data Pembayaran',
        'class' => 'Pembayaran',
        'fields' => [
            'id' => 'ID Pembayaran',
            'nama' => 'Nama Penyewa',
            'jumlah' => 'Jumlah Pembayaran',
            'tanggal' => 'Tanggal',
            'status' => 'Status'
        ]
    ]
];

// Menyiapkan session setiap jenis data
foreach ($config as $jenis => $pengaturan) {
    if (!isset($_SESSION[$jenis])) {
        $_SESSION[$jenis] = [];
    }
}

// Fungsi membuat objek dari class
function buatObjek($jenis, $data)
{
    switch ($jenis) {
        case 'pengguna':
            return new Pengguna(
                $data['nama'],
                $data['email'],
                $data['no_hp']
            );

        case 'pemilik':
            return new Pemilik(
                $data['id'],
                $data['nama'],
                $data['email'],
                $data['no_hp']
            );

        case 'penyewa':
            return new Penyewa(
                $data['id'],
                $data['nama'],
                $data['email'],
                $data['no_hp'],
                $data['nomor_kamar']
            );

        case 'kos':
            return new Kos(
                $data['nama_kos'],
                $data['alamat']
            );

        case 'kamar':
            return new Kamar(
                $data['nomor'],
                $data['harga'],
                $data['status']
            );

        case 'fasilitas':
            return new Fasilitas(
                $data['nama'],
                $data['keterangan']
            );

        case 'pembayaran':
            return new Pembayaran(
                $data['id'],
                $data['nama'],
                $data['jumlah'],
                $data['tanggal'],
                $data['status']
            );
    }
}

// Memproses tambah dan edit
if (isset($_POST['simpan'])) {
    $jenis = $_POST['jenis'];
    $index = $_POST['index'] ?? '';

    if (isset($config[$jenis])) {
        $data = [];

        foreach ($config[$jenis]['fields'] as $field => $label) {
            $data[$field] = trim($_POST[$field] ?? '');
        }

        // Memastikan objek dapat dibuat
        buatObjek($jenis, $data);

        if ($index !== '') {
            $_SESSION[$jenis][$index] = $data;
        } else {
            $_SESSION[$jenis][] = $data;
        }
    }

    header('Location: index.php');
    exit;
}

// Memproses hapus
if (isset($_GET['hapus'], $_GET['jenis'])) {
    $jenis = $_GET['jenis'];
    $index = $_GET['hapus'];

    if (isset($_SESSION[$jenis][$index])) {
        unset($_SESSION[$jenis][$index]);
        $_SESSION[$jenis] = array_values($_SESSION[$jenis]);
    }

    header('Location: index.php');
    exit;
}

// Mengambil data yang akan diedit
$jenisAktif = $_GET['jenis'] ?? 'pengguna';
$indexEdit = $_GET['edit'] ?? '';
$dataEdit = null;

if (
    $indexEdit !== '' &&
    isset($_SESSION[$jenisAktif][$indexEdit])
) {
    $dataEdit = $_SESSION[$jenisAktif][$indexEdit];
}

// Menghindari HTML yang tidak aman
function aman($nilai)
{
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Manajemen Kos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 25px;
            color: #333;
        }

        h1 {
            text-align: center;
        }

        .menu {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin: 25px 0;
        }

        .menu a {
            background: #2878c8;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .menu a.aktif {
            background: #174c80;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            overflow-x: auto;
        }

        input {
            width: 95%;
            padding: 10px;
            margin: 7px 0 15px;
        }

        button {
            padding: 10px 15px;
            border: none;
            background: #2878c8;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #e8e8e8;
        }

        .edit {
            color: blue;
            text-decoration: none;
        }

        .hapus {
            color: red;
            text-decoration: none;
        }
    </style>
</head>

<body>

<h1>Sistem Informasi Manajemen Kos</h1>

<p style="text-align:center;">
    Program Pengelolaan Data Kos Berbasis OOP PHP
</p>

<div class="menu">
    <?php foreach ($config as $jenis => $pengaturan) : ?>
        <a
            href="index.php?jenis=<?= $jenis; ?>"
            class="<?= $jenisAktif == $jenis ? 'aktif' : ''; ?>"
        >
            <?= aman($pengaturan['judul']); ?>
        </a>
    <?php endforeach; ?>
</div>

<?php if (isset($config[$jenisAktif])) : ?>

<div class="container">

    <h2>
        <?= aman($config[$jenisAktif]['judul']); ?>
    </h2>

    <h3>
        <?= $dataEdit ? 'Edit Data' : 'Tambah Data'; ?>
    </h3>

    <form method="POST">

        <input type="hidden" name="jenis"
               value="<?= aman($jenisAktif); ?>">

        <input type="hidden" name="index"
               value="<?= aman($indexEdit); ?>">

        <?php foreach ($config[$jenisAktif]['fields'] as $field => $label) : ?>

            <label><?= aman($label); ?></label><br>

            <input
                type="text"
                name="<?= aman($field); ?>"
                value="<?= aman($dataEdit[$field] ?? ''); ?>"
                placeholder="Masukkan <?= aman($label); ?>"
                required
            >

            <br>

        <?php endforeach; ?>

        <button type="submit" name="simpan">
            <?= $dataEdit ? 'Simpan Perubahan' : 'Tambah Data'; ?>
        </button>

        <?php if ($dataEdit) : ?>
            <a href="index.php?jenis=<?= aman($jenisAktif); ?>">
                Batal
            </a>
        <?php endif; ?>

    </form>

</div>

<div class="container">

    <h2>Daftar <?= aman($config[$jenisAktif]['judul']); ?></h2>

    <table>
        <tr>
            <th>No</th>

            <?php foreach ($config[$jenisAktif]['fields'] as $label) : ?>
                <th><?= aman($label); ?></th>
            <?php endforeach; ?>

            <th>Aksi</th>
        </tr>

        <?php if (count($_SESSION[$jenisAktif]) > 0) : ?>

            <?php foreach ($_SESSION[$jenisAktif] as $index => $item) : ?>

                <?php
                $objek = buatObjek($jenisAktif, $item);
                ?>

                <tr>
                    <td><?= $index + 1; ?></td>

                    <?php foreach ($config[$jenisAktif]['fields'] as $field => $label) : ?>
                        <td>
                            <?php if ($field == 'harga' || $field == 'jumlah') : ?>
                                Rp <?= number_format((float)$item[$field], 0, ',', '.'); ?>
                            <?php else : ?>
                                <?= aman($item[$field]); ?>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>

                    <td>
                        <a
                            class="edit"
                            href="index.php?jenis=<?= aman($jenisAktif); ?>&edit=<?= $index; ?>"
                        >
                            Edit
                        </a>

                        |

                        <a
                            class="hapus"
                            href="index.php?jenis=<?= aman($jenisAktif); ?>&hapus=<?= $index; ?>"
                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                        >
                            Hapus
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>

        <?php else : ?>

            <tr>
                <td colspan="<?= count($config[$jenisAktif]['fields']) + 2; ?>">
                    Belum ada data.
                </td>
            </tr>

        <?php endif; ?>

    </table>

</div>

<?php endif; ?>

</body>
</html>
