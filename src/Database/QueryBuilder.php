<?php

namespace Gobel\Database;

class QueryBuilder
{
    /**
     * The database connection instance.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * The table which the query is targeting.
     *
     * @var string
     */
    protected $table;

    /**
     * The columns that should be returned.
     *
     * @var array
     */
    protected $columns = ['*'];

    /**
     * The where constraints for the query.
     *
     * @var array
     */
    protected $wheres = [];

    /**
     * The bindings for the query.
     *
     * @var array
     */
    protected $bindings = [];
    
    /**
     * The orderings for the query.
     *
     * @var array
     */
    protected $orders = [];

    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    protected $limit;

    /**
     * Create a new query builder instance.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Set the columns to be selected.
     *
     * @param array|mixed $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();

        return $this;
    }

    /**
     * Set the table which the query is targeting.
     *
     * @param string $table
     * @return $this
     */
    public function from(string $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param string $column
     * @param mixed $operator
     * @param mixed $value
     * @return $this
     */
    public function where($column, $operator = null, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = compact('column', 'operator', 'value');
        $this->bindings[] = $value;

        return $this;
    }
    
    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orders[] = [
            'column' => $column,
            'direction' => strtolower($direction) === 'asc' ? 'asc' : 'desc',
        ];

        return $this;
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function limit($value)
    {
        if ($value >= 0) {
            $this->limit = $value;
        }

        return $this;
    }
    
    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return array
     */
    public function get($columns = ['*'])
    {
        if ($columns !== ['*']) {
            $this->select($columns);
        }

        return $this->connection->select($this->toSql(), $this->getBindings());
    }

    /**
     * Execute a query for a single record by ID.
     *
     * @param  int|string  $id
     * @param  array  $columns
     * @return mixed|static
     */
    public function find($id, $columns = ['*'])
    {
        return $this->where('id', '=', $id)->first($columns);
    }

    /**
     * Execute the query and get the first result.
     *
     * @param  array  $columns
     * @return mixed|static
     */
    public function first($columns = ['*'])
    {
        return $this->limit(1)->get($columns)[0] ?? null;
    }

    /**
     * Insert a new record into the database.
     *
     * @param  array  $values
     * @return bool
     */
    public function insert(array $values)
    {
        if (empty($values)) {
            return true;
        }

        $columns = implode(', ', array_keys($values));
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        $sql = "insert into {$this->table} ({$columns}) values ({$placeholders})";

        return $this->connection->insert($sql, array_values($values));
    }

    /**
     * Insert a new record and get the value of the primary key.
     *
     * @param  array  $values
     * @return int
     */
    public function insertGetId(array $values)
    {
        $this->insert($values);

        return $this->connection->lastInsertId();
    }

    /**
     * Update a record in the database.
     *
     * @param  array  $values
     * @return int
     */
    public function update(array $values)
    {
        $columns = implode(', ', array_map(function ($key) {
            return "{$key} = ?";
        }, array_keys($values)));

        $sql = "update {$this->table} set {$columns} " . $this->compileWheres();

        return $this->connection->update($sql, array_merge(array_values($values), $this->bindings));
    }

    /**
     * Delete a record from the database.
     *
     * @return int
     */
    public function delete()
    {
        $sql = "delete from {$this->table} " . $this->compileWheres();

        return $this->connection->delete($sql, $this->bindings);
    }

    /**
     * Get the SQL representation of the query.
     *
     * @return string
     */
    public function toSql()
    {
        $columns = implode(', ', $this->columns);

        $sql = "select {$columns} from {$this->table}";

        // Compile Wheres
        $sql .= $this->compileWheres();

        // Compile Orders
        $sql .= $this->compileOrders();
        
        // Compile Limit
        if (isset($this->limit)) {
            $sql .= " limit {$this->limit}";
        }

        return $sql;
    }

    /**
     * Compile the where clauses.
     *
     * @return string
     */
    protected function compileWheres()
    {
        $sql = '';
        
        if (!empty($this->wheres)) {
            $wheres = array_map(function ($where) {
                return $where['column'] . ' ' . $where['operator'] . ' ?';
            }, $this->wheres);

            $sql .= ' where ' . implode(' and ', $wheres);
        }

        return $sql;
    }
    
    /**
     * Compile the order by clauses.
     *
     * @return string
     */
    protected function compileOrders()
    {
        $sql = '';
        
        if (!empty($this->orders)) {
            $orders = array_map(function ($order) {
                return $order['column'] . ' ' . $order['direction'];
            }, $this->orders);

            $sql .= ' order by ' . implode(', ', $orders);
        }

        return $sql;
    }

    /**
     * Get the current bindings.
     *
     * @return array
     */
    public function getBindings()
    {
        return $this->bindings;
    }
}
