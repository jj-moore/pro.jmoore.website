<?php
require_once 'php/db_functions.php';
$width = intval(@$_REQUEST['width']);
$height = intval(@$_REQUEST['height']);
$depth = intval(@$_REQUEST['depth']);
$surfaceArea = ($width * $height) * 2 + ($width * $depth) * 2 + ($height * $depth) * 2;
$totalVolume = $width * $height * $depth;

$totalFishCount = floor($totalVolume / 275);
$fancyFishCount = floor($totalFishCount * .07);
$regularFishCount = $totalFishCount - $fancyFishCount;

$glassCost = $surfaceArea * .03;
$waterCost = $totalVolume * 0.001;
$fancyFishCost = $fancyFishCount * 1.98;
$regularFishCost = $regularFishCount * 0.61;
$decorations = 7.95;

$totalCost = $glassCost + $waterCost + $fancyFishCost + $regularFishCost + $decorations;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lake Superior Aquarium Company</title>
    <link rel="stylesheet" href="css/simple_php.css">
</head>
<body>
<h2>Lake Superior Aquarium Company</h2>
<h3>Cost Estimator</h3>
<?php echo "<p>" . getResultsCount() . "</p>"; ?>
<form action='simple_php.php'>
    <table>
        <tr>
            <td id='title'>Enter Width (cm)</td>
            <td><input type='text' name='width' value='<?= $width ?>' id='entry'></td>
        </tr>
        <tr>
            <td id='title'>Enter Height (cm)</td>
            <td><input type='text' name='height' value='<?= $height ?>' id='entry'></td>
        </tr>
        <tr>
            <td id='title'>Enter Depth (cm)</td>
            <td><input type='text' name='depth' value='<?= $depth ?>' id='entry'></td>
        </tr>
        <tr>
            <td colspan='2'><input type='submit' value='Calculate Quote' id="button"></td>
    </table>
</form>
<br>

<?php if ($width > 0 && $height > 0 && $depth > 0) { ?>
    <table>
        <tr>
            <td id='title'>Surface Area (cm2):</td>
            <td align="right" id='text'><?= number_format($surfaceArea, 0, '.', ',') ?></td>
        <tr>
            <td id='title'>Volume (cm3):</td>
            <td align="right" id='text'><?= number_format($totalVolume, 0, '.', ',') ?></td>
        <tr>
            <td id='title'>Regular Fish:</td>
            <td align="right" id='text'><?= number_format($regularFishCount, 0, '.', ',') ?></td>
        <tr>
            <td id='title'>Fancy Fish:</td>
            <td align="right" id='text'><?= number_format($fancyFishCount, 0, '.', ',') ?></td>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td id='title'>Glass:</td>
            <td align="right" id='text'><?= '$' . number_format($glassCost, 2, '.', ',') ?></td>
        <tr>
            <td id='title'>Filtered Water:</td>
            <td align="right" id='text'><?= '$' . number_format($waterCost, 2, '.', ',') ?></td>
        <tr>
            <td id='title'>Regular Fish:</td>
            <td align="right" id='text'><?= '$' . number_format($regularFishCost, 2, '.', ',') ?></td>
        <tr>
            <td id='title'>Fancy Fish:</td>
            <td align="right" id='text'><?= '$' . number_format($fancyFishCost, 2, '.', ',') ?></td>
        <tr>
            <td id='title'>Castle and Lighting:</td>
            <td align="right" id='text'><?= '$' . number_format($decorations, 2, '.', ',') ?></td>
        <tr>
            <td colspan='2'>
                <hr>
            </td>
        </tr>
        <tr>
            <td id='totaltitle'>Total Costs:</td>
            <td align="right" id='total'><?= '$' . number_format($totalCost, 2, '.', ',') ?></td>
    </table>
    <?php
} else {
    echo "<p>" . 'Please enter integer dimensions (cm)' . '</p>';
}
?>
</body>
</html>
