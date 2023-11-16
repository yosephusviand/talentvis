<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Deposit/Withdraw</title>
</head>

<body>
    <div class="container">
        <h1>Balance: $<?= $walletModel->getBalance() ?></h1>

        <form action="index.php?action=home" method="post">
            <div class="form-group mb-3">
                <label for="type">Type</label>
                <select name="type" class="form-control" id="type">
                    <option value="" disabled selected hidden>Select </option>
                    <option value="deposit">Deposit</option>
                    <option value="withdraw">Withdraw</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="nominal">Amount</label>
                <input type="text" name="nominal" class="form-control" id="nominal" placeholder="Tuliskan " value="" autocomplete="off">
            </div>
            <div class="form-group mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Type</th>
                    <th>Credit</th>
                    <th>Debit</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($walletModel->getData() as $balance) {
                ?>
                    <tr>
                        <td><?= $balance['created_at'] ?></td>
                        <td><?= $balance['type'] ?></td>
                        <td><?= $balance['credit'] ?></td>
                        <td><?= $balance['debit'] ?></td>
                        <td><?= $balance['saldo'] ?></td>
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