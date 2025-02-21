<?php
//declare(s)

class QueryBuilder
{
    private SupabaseClient $client;
    private string $table;
    private array $filters = [];
    private array $joins = [];
    private ?string $aggregate = null;
    private ?string $subquery = null;
    private array $groupBy = [];
    private array $having = [];
    private array $customExpressions = [];
    private int $limit = 0;
    private int $offset = 0;
    private array $orderBy = [];
    private bool $distinct = false;

    public function __construct(SupabaseClient $client)
    {
        $this->client = $client;
    }

    public function select(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function distinct(): self
    {
        $this->distinct = true;
        return $this;
    }

    public function where(string $column, mixed $value): self
    {
        $this->filters[$column] = $value;
        return $this;
    }

    public function join(string $table, string $column1, string $column2): self
    {
        $this->joins[] = ['type' => 'INNER', 'table' => $table, 'on' => "$column1 = $column2"];
        return $this;
    }

    public function leftJoin(string $table, string $column1, string $column2): self
    {
        $this->joins[] = ['type' => 'LEFT', 'table' => $table, 'on' => "$column1 = $column2"];
        return $this;
    }

    public function rightJoin(string $table, string $column1, string $column2): self
    {
        $this->joins[] = ['type' => 'RIGHT', 'table' => $table, 'on' => "$column1 = $column2"];
        return $this;
    }

    public function innerJoin(string $table, string $column1, string $column2): self
    {
        $this->joins[] = ['type' => 'INNER', 'table' => $table, 'on' => "$column1 = $column2"];
        return $this;
    }

    public function count(string $column = '*'): self
    {
        $this->aggregate = "COUNT($column)";
        return $this;
    }

    public function sum(string $column): self
    {
        $this->aggregate = "SUM($column)";
        return $this;
    }

    public function avg(string $column): self
    {
        $this->aggregate = "AVG($column)";
        return $this;
    }

    public function max(string $column): self
    {
        $this->aggregate = "MAX($column)";
        return $this;
    }

    public function min(string $column): self
    {
        $this->aggregate = "MIN($column)";
        return $this;
    }

    public function subquery(QueryBuilder $subQuery, string $alias): self
    {
        $this->subquery = "($subQuery->toSql()) AS $alias";
        return $this;
    }

    public function groupBy(string $column): self
    {
        $this->groupBy[] = $column;
        return $this;
    }

    public function having(string $condition): self
    {
        $this->having[] = $condition;
        return $this;
    }

    public function customExpression(string $expression): self
    {
        $this->customExpressions[] = $expression;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy[] = "$column $direction";
        return $this;
    }

    public function limit(int $count): self
    {
        $this->limit = $count;
        return $this;
    }

    public function offset(int $count): self
    {
        $this->offset = $count;
        return $this;
    }

    public function get(): array
    {
        $query = $this->client->from($this->table);

        if ($this->aggregate) {
            $query = $query->select($this->aggregate);
        } else {
            $query = $this->distinct ? $query->select('DISTINCT *') : $query->select('*');
        }

        foreach ($this->filters as $col => $val) {
            $query = $query->eq($col, $val);
        }

        foreach ($this->joins as $join) {
            $query = $query->rpc('join_query', [
                'type' => $join['type'],
                'table' => $join['table'],
                'on' => $join['on']
            ]);
        }

        if ($this->subquery) {
            $query = $query->rpc('subquery', ['query' => $this->subquery]);
        }

        if (!empty($this->groupBy)) {
            $query = $query->groupBy(implode(', ', $this->groupBy));
        }

        if (!empty($this->having)) {
            $query = $query->having(implode(' AND ', $this->having));
        }

        if (!empty($this->customExpressions)) {
            foreach ($this->customExpressions as $expr) {
                $query = $query->select($expr);
            }
        }

        if (!empty($this->orderBy)) {
            $query = $query->orderBy(implode(', ', $this->orderBy));
        }

        if ($this->limit > 0) {
            $query = $query->limit($this->limit);
        }

        if ($this->offset > 0) {
            $query = $query->range($this->offset, $this->offset + $this->limit - 1);
        }

        return $query->execute();
    }
}
