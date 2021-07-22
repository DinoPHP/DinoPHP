<?php

namespace DinoPHP\Database;

use DinoPHP\File\File;
use DinoPHP\Http\Request;
use DinoPHP\Http\Response;
use DinoPHP\Url\Url;
use PDO;
use Exception;

class Database {
	/**
	 * Database Instance
	 */
	protected static $instance;

	/**
	 * Database Connection
	 * @var
	 */
	protected static $connection;

	/**
	 * Select data
	 * @var array
	 */
	protected static $select;

	/**
	 * Table name
	 * @var array
	 */
	protected static $table;

	/**
	 * Join data
	 * @var string
	 */
	protected static $join;

	/**
	 * Where data
	 * @var string
	 */
	protected static $where;

	/**
	 * Where Binding
	 * @var array
	 */
	protected static $where_binding = [];

	/**
	 * Group By
	 * @var string
	 */
	protected static $group_by;

	/**
	 * Having data
	 * @var array
	 */
	protected static $having;


	/**
	 * Having Binding
	 * @var array
	 */
	protected static $having_binding = [];

	/**
	 * Order By
	 * @var string
	 */
	protected static $order_by;

	/**
	 * Limit data
	 * @var string
	 */
	protected static $limit;

	/**
	 * Offset
	 * @var string
	 */
	protected static $offset;

	/**
	 * Query
	 * @var string
	 */
	protected static $query;

	/**
	 * Setter
	 * @var string
	 */
	protected static $setter;

	/**
	 * All Binding
	 * @var array
	 */
	protected static $binding = [];


	/**
	 * Database constructor.
	 */
	private function __construct() {}


	/**
	 * Connect to database
	 */
	private static function connect() {
		if(! static::$connection) {
			$database_data = File::require_file('config/database.php');
			extract($database_data);
			$dsn = 'mysql:host=' . $host . ';dbname=' . $database;
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
				PDO::ATTR_PERSISTENT => false,
				PDO::MYSQL_ATTR_INIT_COMMAND => 'set NAMES ' . $charset . ' COLLATE ' . $collation,
			];
			try {
				static::$connection = new PDO($dsn, $username, $password, $options);
			}
			catch (PDOException $e) {
				throw new Exception($e->getMessage());
			}
		}
	}

	/**
	 * Get the Instance
	 */
	private static function instance() {
		static::connect();
		if(! self::$instance) {
			self::$instance = new Database();
		}
		return self::$instance;
	}

	/**
	 * Query Function
	 * @param null $query
	 */
	public static function query($query = null) {
		static::instance();
		if($query == null) {
			if(! static::$table) {
				throw new Exception("Unknown table");
			}
			$query = "SELECT ";
			$query .= static::$select ?: '*';
			$query .= " FROM " . static::$table . "";
			$query .= static::$join . " ";
			$query .= static::$where . " ";
			$query .= static::$group_by . " ";
			$query .= static::$having . " ";
			$query .= static::$order_by . " ";
			$query .= static::$limit . " ";
			$query .= static::$offset . " ";
		}
		static::$query = $query;
		static::$binding = array_merge(static::$where_binding, static::$having_binding);

		return static::instance();
	}

	/**
	 * Select data from table
	 */
	public static function select() {
		$select = func_get_args();
		$select = implode(', ', $select);
		static::$select = $select;
		return static::instance();
	}
	/**
	 * Define table
	 */
	public static function table($table) {
		static::$table = $table;
		return static::instance();
	}

	/**
	 * Join table
	 * @param string $table
	 * @param string $first
	 * @param string $operator
	 * @param string $second
	 * @param string $type
	 *
	 * @return object $type
	 */
	public static function join($table, $first, $operator, $second, $type = "INNER") {
		static::$join .= " " . $type . " JOIN " . $table . " ON " . $first . $operator . $second . " ";
		return static::instance();
	}

	/**
	 * Right Join table
	 * @param string $table
	 * @param string $first
	 * @param string $operator
	 * @param string $second
	 *
	 * @return object $type
	 */
	public static function rightJoin($table, $first, $operator, $second) {
		static::join($table, $first, $operator,$second, "RIGHT");
		return static::instance();
	}

	/**
	 * Left Join table
	 * @param string $table
	 * @param string $first
	 * @param string $operator
	 * @param string $second
	 *
	 * @return object $type
	 */
	public static function leftJoin($table, $first, $operator, $second) {
		static::join($table, $first, $operator,$second, "LEFT");
		return static::instance();
	}

	/**
	 * Where data
	 * @param string $column
	 * @param string $operator
	 * @param string $value
	 * @param string $type
	 *
	 * @return object $instance
	 */
	public static function where($column, $operator, $value, $type = null) {
		$where = "`" . $column . "`" . $operator . " ? ";
		if(! static::$where) {
			$statement = " WHERE " . $where;
		} else {
			if($type == null) {
				$statement = " AND " . $where;
			} else {
				$statement = " " . $type . " " . $where;
			}
		}

		static::$where .= $statement;
		static::$where_binding[] = htmlspecialchars($value);

		return static::instance();
	}

	/**
	 * OR WHERE
	 * @param string $column
	 * @param string $operator
	 * @param string $value
	 *
	 * @return object $value
	 */
	public static function orWhere($column, $operator, $value) {
		static::where($column, $operator, $value, "OR");
		return static::instance();
	}

	/**
	 * Group By
	 * @return object $instance
	 */
	public static function groupBy() {
		$group_by = func_get_args();
		$group_by = " GROUP BY " . implode(', ', $group_by) . " ";
		static::$group_by = $group_by;
		return static::instance();
	}

	/**
	 * Having data
	 * @param string $column
	 * @param string $operator
	 * @param string $value
	 *
	 * @return object $instance
	 */
	public static function having($column, $operator, $value) {
		$having = "`" . $column . "`" . $operator . " ? ";
		if(! static::$having) {
			$statement = " HAVING " . $having;
		} else {
			$statement = " AND " . $having;
		}

		static::$having .= $statement;
		static::$having_binding[] = htmlspecialchars($value);

		return static::instance();
	}

	/**
	 * ORDER BY
	 * @param string $column
	 * @param string $type
	 *
	 * @return object $instance
	 */
	public static function orderBy($column, $type = null) {
		$sep = static::$order_by ? " , " : " ORDER BY ";
		$type = strtoupper($type);
		$type = ($type != null && in_array($type, ['ASC', 'DESC'])) ? $type : "ASC";
		$statement = $sep . $column . " " . $type . " ";

		static::$order_by .= $statement;
		return static::instance();
	}

	/**
	 * Limit
	 * @param string $limit
	 *
	 * @return object $instance
	 */
	public static function limit($limit) {
		static::$limit = " LIMIT " . $limit . " ";
		return static::instance();
	}

	/**
	 * Offset
	 * @param string $offset
	 *
	 * @return object $instance
	 */
	public static function offset($offset) {
		static::$offset = " OFFSET " . $offset . " ";
		return static::instance();
	}

	/**
	 * Fetch Execute
	 *
	 * @return object $data
	 * @throws Exception
	 */
	private static function fetchExecute() {
		static::query(static::$query);
		$query = trim(static::$query, ' ');
		$data = static::$connection->prepare($query);
		$data->execute(static::$binding);

		static::clear();

		return $data;
	}

	/**
	 * Get records
	 *
	 * @return object $result
	 * @throws Exception
	 */
	public static function get() {
		$data = static::fetchExecute();
		$result = $data->fetchAll();

		return $result;
	}

	/**
	 * First records
	 *
	 * @return object $result
	 * @throws Exception
	 */
	public static function first() {
		$data = static::fetchExecute();
		$result = $data->fetch();

		return $result;
	}

	/**
	 * Execute
	 *
	 * @param array $data
	 * @param string $query
	 * @param bool|null $where
	 *
	 * @return void
	 * @throws Exception
	 */
	private static function execute(Array $data, $query, $where = null){
		static::instance();
		if(! static::$table) {
			throw new Exception("Unknown table");
		}

		foreach ($data as $key => $value) {
			static::$setter .= '`' . $key . '` = ?, ';
			static::$binding[] = filter_var($value, FILTER_SANITIZE_STRING);
		}
		static::$setter = trim(static::$setter, ', ');

		$query .= static::$setter;
		$query .= $where != null ? static::$where . " " : '';

		static::$binding = $where != null ? array_merge(static::$binding, static::$where_binding) : static::$binding;

		$data = static::$connection->prepare($query);
		$data->execute(static::$binding);

		static::clear();
	}

	/**
	 * Insert to table
	 * @throws Exception
	 */
	public static function insert($data) {
		$table = static::$table;
		$query = "INSERT INTO " . $table . " SET ";
		static::execute($data, $query);

		$object_id = static::$connection->LastInsertId();
		$object = static::table($table)->where('id', '=', $object_id)->first();

		return $object;
	}

	/**
	 * Update records
	 * @param array $data
	 */
	public static function update($data) {
		$query = "UPDATE " . static::$table . " SET ";
		static::execute($data, $query, true);

		return true;
	}

	/**
	 * Delete records
	 * @return bool
	 */
	public static function delete() {
		$query = "DELETE FROM " . static::$table . " ";
		static::execute([], $query, true);

		return true;
	}

	/**
	 * Pagination
	 *
	 * @return mixed $result
	 * Default value = 15
	 */
	public static function paginate($items_per_page = 15) {
		static::query(static::$query);
		$query = trim(static::$query, ' ');
		$data = static::$connection->prepare($query);
		$data->execute();
		$pages = ceil($data->rowCount() / $items_per_page);

		$page = Request::get('page');
		$current_page = (! is_numeric($page) || Request::get('page') < 1) ? "1" : $page;
		$offset = ($current_page-1) * $items_per_page;
		static::limit($items_per_page);
		static::offset($offset);
		static::query();

		$data = static::fetchExecute();
		$result = $data->fetchAll();

		$response = ['data' => $result, 'items_per_page' => $items_per_page, 'pages' => $pages, 'current_page' => $current_page];

		return $response;
	}

	/**
	 * Get Pagination pages
	 *
	 * @param int $current_page
	 * @param int $page
	 * @return string $result
	 */
	public static function links($current_page, $pages) {
		$links = '';
		$from = $current_page - 2;
		$to = $current_page + 2;
		if($from < 2) {
			$from = 2;
			$to = $from + 4;
		}
		if($to >= $pages) {
			$diff = $to - $pages + 1;
			$from = ($from > 2) ? $from - $diff : 2;
			$to = $pages - 1;
		}
		if($from < 2) {
			$from = 1;
		}
		if($to >= $pages) {
			$to = ($pages-1);
		}
		if($pages > 1) {
			$links .= "<ul class='pagination'>";
			$full_link = Url::path(Request::FullUrl());
			$full_link = preg_replace('/\?page=(.*)/', '', $full_link);
			$full_link = preg_replace('/\&page=(.*)/', '', $full_link);

			$current_page_active = $current_page == 1 ? 'active' : '';
			$href = strpos($full_link, '?') ? ($full_link.'&page=1') : ($full_link.'?page=1');
			$links .= "<li class='link' $current_page_active><a href='$href'>First</a></li>";

			for ($i = $from; $i<=$to; $i++) {
				$current_page_active = $current_page == $i ? 'active' : '';
				$href = strpos($full_link, '?') ? ($full_link.'&page='.$i) : ($full_link.'?page='.$i);
				$links .= "<li class='link' $current_page_active><a href='$href'>$i</a></li>";
			}

			if($pages > 1) {
				$current_page_active = $current_page == $pages ? 'active' : '';
				$href = strpos($full_link, '?') ? ($full_link.'&page='.$pages) : ($full_link.'?page='.$pages);
				$links .= "<li class='link' $current_page_active><a href='$href'>Last</a></li>";
			}

			return $links;
		}
	}


	/**
	 * Clear the properties
	 *
	 * @return void
	 */
	private static function clear() {
		static::$select = '';
		static::$join = '';
		static::$where = '';
		static::$where_binding = [];
		static::$group_by = '';
		static::$having = '';
		static::$having_binding = [];
		static::$order_by = '';
		static::$limit = '';
		static::$offset = '';
		static::$query = '';
		static::$binding = [];
		static::$instance = '';
	}
}