<?php

require_once(__DIR__ . '/dbconnect.php');

function query($sql, $data = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($data) {
        $stmt->execute($data);
    } else {
        $stmt->execute();
    }
    return $stmt;
}

function insert($table, $data) {
    $key = array_keys($data);
    $property = implode(',', $key);
    $value = implode(',',array_map(function($v) {
        return ":$v";
    }, $key));
    $sql = "INSERT INTO $table($property) VALUES($value)";
    query($sql, $data);
}

function update($table, $data = [], $where = []) {
    $set = implode(',', array_map(function($v) {
        return "$v=:$v";
    }, array_keys($data)));
    $condition = implode(' AND ', array_map(function($v) {
        return "$v=:$v";
    }, array_keys($where)));
    $sql = "UPDATE $table SET $set WHERE $condition";
    query($sql, array_merge($data, $where));
}

function delete($table, $where = []) {
    $condition = implode(' AND ', array_map(function($v) {
        return "$v=:$v";
    }, array_keys($where)));
    $sql = "DELETE FROM $table WHERE $condition";
    query($sql, $where);
}

function getRow($sql, $data = []) {
    return query($sql, $data)->fetch();
}

function getRows($sql, $data = []) {
    return query($sql, $data)->fetchAll();
}
?>