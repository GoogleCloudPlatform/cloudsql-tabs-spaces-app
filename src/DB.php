<?php
# Copyright 2020 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

namespace Google\Cloud\Samples\CloudSQL\TabsVsSpaces;

use PDO;

class DB
{
    public static function createPdoConnection()
    {
        $username = getenv("DB_USER");
        $password = getenv("DB_PASS");
        $schema = getenv("DB_NAME");
        $hostname = getenv("DB_HOSTNAME") ?: "127.0.0.1";
        $cloud_sql_connection_name = getenv("CLOUD_SQL_CONNECTION_NAME");
        # [START cloud_sql_mysql_pdo_create]

        if ($cloud_sql_connection_name) {
            // Connect using UNIX sockets
            $dsn = sprintf(
                'mysql:dbname=%s;unix_socket=/cloudsql/%s',
                $schema,
                $cloud_sql_connection_name
            );
        } else {
            // Connect using TCP
            // $hostname = '127.0.0.1';
            $dsn = sprintf('mysql:dbname=%s;host=%s', $schema, $hostname);
        }
        
        try {
            return new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (\PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            die("Error connecting to the database");
        }

        # [END cloud_sql_mysql_pdo_create]
    }
}
