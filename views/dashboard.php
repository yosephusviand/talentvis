<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Dashboard</title>
</head>

<body>
    <div class="container">
        <?php $id = $user["id"]; ?>
        <h1>Balance: $<?= $walletModel->getBalance($id) ?> </h1>
        <form action="index.php?action=dashboard" method="POST">
            <input type="hidden" name="id" id="id" value="<?= $user['id'] ?>">
            <div class="form-group mb-2">
                <label for="type">Type</label>
                <select name="type" class="form-control" id="type">
                    <option value="" disabled selected hidden>Pilih </option>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="tf_to">Transfer To</label>
                <select name="tf_to" class="form-control" id="tf_to">
                    <option value="" disabled selected hidden>Pilih </option>
                    <?php
                    foreach ($model->getAllData($user['id']) as $user) {
                    ?>
                        <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
                <div class="form-group mb-2">
                    <label for="nominal">Amount</label>
                    <input type="number" name="nominal" class="form-control" id="nominal" placeholder="Tuliskan " value="" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
        </form>
        <br />
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($walletModel->getData($id) as $balance) {
                ?>
                    <tr>
                        <td><?= $balance['created_at'] ?></td>
                        <td><?= $balance['type'] ?></td>
                        <td><?= $balance['debit'] ?></td>
                        <td><?= $balance['credit'] ?></td>
                        <td><?= $balance['saldo'] ?></td>
                        <td>
                            <?php
                            if ($balance['tf_to']) {
                                echo "Transfer to " . $balance['name'];
                            } elseif ($balance['tf_from']) {
                                echo "Transfer from " . $balance['name'];
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>