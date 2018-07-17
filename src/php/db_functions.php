<?php

function getPDO()
{
    try {
        return pg_connect("host=localhost dbname=jmoore7_default user=jmoore7_jmoore");
        /*
        $db = new PDO(
            'jdbc:postgresql://localhost:5432/jmoore7_default',
            'jmoore7_jmoore',
            'Tr33%2071');
        return true;
        */
    } catch (PDOException $e1) {
        return $e1;
        // To use header, you must not have sent any response output yet.
        //header("Location: error.php?error=A database error occured.<br>" . $e1->getMessage());
    } catch (Exception $e2) {
        return $e2;
        //header("Location: error.php?error=An error occured.<br>" . $e2->getMessage());
    }
}

function execWithReturn($db, $sql, $returnResults = true)
{
    try {
        $statement = $db->prepare($sql);
        $statement->execute();
        $results = array();
        if ($returnResults) {
            $results = $statement->fetchAll();
        }
        $statement->closeCursor();
        return $results;
    } catch (PDOException $e1) {
        // To use header, you must not have sent any response output yet.
        header("Location: error.php?error=A database error occured.<br>" . $e1->getMessage());
    } catch (Exception $e2) {
        header("Location: error.php?error=An error occured.<br>" . $e2->getMessage());
    }
}

function execNoReturn($db, $sql)
{
    execWithReturn($db, $sql, false);
}

function convertResult($result)
{
    switch ($result) {
        case '1':
            return 'Player 1';
        case '2':
            return 'Player 2';
        case 'D':
            return 'Draw';
        default:
            return '';
    }
}

function getWhereClause($dateStart, $dateEnd, $nameLike, $matchResult)
{
    $whereClause = "";
    if (!empty($dateStart))
        $whereClause .= " AND matchDate >= '" . $dateStart . "'";
    if (!empty($dateEnd))
        $whereClause .= " AND matchDate <= '" . $dateEnd . "'";
    if (!empty($nameLike))
        $whereClause .= " AND (player1 LIKE '%" . $nameLike . "%' OR player2 LIKE '%" . $nameLike . "%')";
    if (!empty($matchResult) && $matchResult != '0')
        $whereClause .= " AND result = '" . $matchResult . "'";

    if (empty($whereClause))
        return "";
    else
        return " WHERE" . substr($whereClause, 4);
}

function getResultsCount()
{
    $count = execWithReturn(getPDO(), "SELECT COUNT(id) FROM project");
    return $count[0][0];
}

function getResults($whereClause, $intLimit)
{
    $select = "SELECT id, name, url, description FROM project";
    $select .= $whereClause . " LIMIT " . $intLimit;
    return execWithReturn(getPDO(), $select);
}
