<?php
//application functions

function get_project_list() 
{
    include 'connection.php';

    try {
        return $db->query('SELECT project_id, title, category FROM projects');
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "</br>";
        return array();
    }
}

function get_task_list($filter = null)  
{
    include 'connection.php';

    $sql = 'SELECT tasks.*, projects.title as project FROM tasks'
        . ' JOIN projects ON tasks.project_id = projects.project_id';
    $where = '';


    if (is_array($filter)) {
        switch ($filter[0]) {
            case 'project':
            $where = ' WHERE projects.project_id = ?';
        break;
        case 'category':
            $where = ' WHERE category = ?';
        break;
        case 'date':
            $where = ' WHERE date >= ? AND date <= ?';
        break;
        }
    }

    $orderBy = ' ORDER BY date DESC';
    if ($filter) {
        $orderBy = ' ORDER BY projects.title ASC, date DESC';
    }
    
    try {                                  

        $result = $db->prepare($sql . $where . $orderBy);
        if (is_array($filter)) {
            $result->bindValue(1, $filter[1]);
            if ($filter[0] == 'date') {
                $result->bindValue(2, $filter[2],PDO::PARAM_STR);
                
            }
        }
        $result->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "</br>";
        return array();
    }
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function add_project($title, $category, $project_id = null) {
    include 'connection.php';

    if ($project_id) {
        $sql = 'UPDATE projects SET title = ?, category = ? WHERE project_id = ?';
    } else {
        $sql = 'INSERT INTO projects(title, category) VALUES(?, ?)';
    }

    try {
        $result = $db->prepare($sql);
        $result->bindValue(1, $title, PDO::PARAM_STR);
        $result->bindValue(2, $category, PDO::PARAM_STR);
        if ($project_id) {
            $result->bindValue(3, $project_id, PDO::PARAM_INT);
        }
        $result->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}

function get_project($project_id) {
    include 'connection.php';

    $sql = 'SELECT * FROM projects WHERE project_id = ?';

    try {
        $result = $db->prepare($sql);
        $result->bindValue(1, $project_id, PDO::PARAM_INT);
        $result->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $result->fetch();
}

function get_task($task_id) {
    include 'connection.php';

    $sql = 'SELECT task_id, title, date, time, project_id FROM tasks WHERE task_id = ?';

    try {
        $result = $db->prepare($sql);
        $result->bindValue(1, $task_id, PDO::PARAM_INT);
        $result->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return $result->fetch();
}

function delete_task($task_id) {
    include 'connection.php';

    $sql = 'DELETE FROM tasks WHERE task_id = ?';

    try {
        $result = $db->prepare($sql);
        $result->bindValue(1, $task_id, PDO::PARAM_INT);
        $result->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}

function delete_project($task_id) {
    include 'connection.php';

    $sql = 'DELETE FROM projects WHERE project_id = ?'
    . 'AND project_id NOT IN(SELECT project_id from tasks)';

    try {
        $result = $db->prepare($sql);
        $result->bindValue(1, $task_id, PDO::PARAM_INT);
        $result->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    if ($result->rowCount()){
        return true;
    }else{
        return false;
    }
}

function add_task($project_id, $title, $date, $time, $task_id = null) {
    include 'connection.php';

    if ($task_id) {
        $sql = 'UPDATE tasks SET project_id = ?, title = ?, date = ?, time = ?'
        . ' WHERE task_id = ?';
    }else{
        $sql = 'INSERT INTO  tasks(project_id, title, date, time) VALUES(?,?,?,?)';
    }

    try {
        $result = $db->prepare($sql);
        $result->bindValue(1, $project_id, PDO::PARAM_INT);
        $result->bindValue(2, $title, PDO::PARAM_STR);
        $result->bindValue(3, $date, PDO::PARAM_STR);
        $result->bindValue(4, $time, PDO::PARAM_INT);
        if ($task_id){
            $result->bindValue(5,$task_id, PDO::PARAM_INT);
        }
        $result->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}