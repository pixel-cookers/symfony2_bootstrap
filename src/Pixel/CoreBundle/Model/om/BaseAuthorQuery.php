<?php

namespace Pixel\CoreBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelPDO;
use Pixel\CoreBundle\Model\Author;
use Pixel\CoreBundle\Model\AuthorPeer;
use Pixel\CoreBundle\Model\AuthorQuery;
use Pixel\CoreBundle\Model\Book;

/**
 * Base class that represents a query for the 'author' table.
 *
 * 
 *
 * @method     AuthorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     AuthorQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     AuthorQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 *
 * @method     AuthorQuery groupById() Group by the id column
 * @method     AuthorQuery groupByFirstName() Group by the first_name column
 * @method     AuthorQuery groupByLastName() Group by the last_name column
 *
 * @method     AuthorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     AuthorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     AuthorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     AuthorQuery leftJoinBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the Book relation
 * @method     AuthorQuery rightJoinBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Book relation
 * @method     AuthorQuery innerJoinBook($relationAlias = null) Adds a INNER JOIN clause to the query using the Book relation
 *
 * @method     Author findOne(PropelPDO $con = null) Return the first Author matching the query
 * @method     Author findOneOrCreate(PropelPDO $con = null) Return the first Author matching the query, or a new Author object populated from the query conditions when no match is found
 *
 * @method     Author findOneById(int $id) Return the first Author filtered by the id column
 * @method     Author findOneByFirstName(string $first_name) Return the first Author filtered by the first_name column
 * @method     Author findOneByLastName(string $last_name) Return the first Author filtered by the last_name column
 *
 * @method     array findById(int $id) Return Author objects filtered by the id column
 * @method     array findByFirstName(string $first_name) Return Author objects filtered by the first_name column
 * @method     array findByLastName(string $last_name) Return Author objects filtered by the last_name column
 *
 * @package    propel.generator.src.Pixel.CoreBundle.Model.om
 */
abstract class BaseAuthorQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseAuthorQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Pixel\\CoreBundle\\Model\\Author', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new AuthorQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    AuthorQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof AuthorQuery) {
			return $criteria;
		}
		$query = new AuthorQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key.
	 * Propel uses the instance pool to skip the database if the object exists.
	 * Go fast if the query is untouched.
	 *
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    Author|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = AuthorPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(AuthorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		if ($this->formatter || $this->modelAlias || $this->with || $this->select
		 || $this->selectColumns || $this->asColumns || $this->selectModifiers
		 || $this->map || $this->having || $this->joins) {
			return $this->findPkComplex($key, $con);
		} else {
			return $this->findPkSimple($key, $con);
		}
	}

	/**
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    Author A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `FIRST_NAME`, `LAST_NAME` FROM `author` WHERE `ID` = :p0';
		try {
			$stmt = $con->prepare($sql);			
			$stmt->bindValue(':p0', $key, PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new Author();
			$obj->hydrate($row);
			AuthorPeer::addInstanceToPool($obj, (string) $key);
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    Author|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(AuthorPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(AuthorPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterById(1234); // WHERE id = 1234
	 * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
	 * $query->filterById(array('min' => 12)); // WHERE id > 12
	 * </code>
	 *
	 * @param     mixed $id The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(AuthorPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the first_name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
	 * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $firstName The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByFirstName($firstName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($firstName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $firstName)) {
				$firstName = str_replace('*', '%', $firstName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(AuthorPeer::FIRST_NAME, $firstName, $comparison);
	}

	/**
	 * Filter the query on the last_name column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
	 * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $lastName The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByLastName($lastName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($lastName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $lastName)) {
				$lastName = str_replace('*', '%', $lastName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(AuthorPeer::LAST_NAME, $lastName, $comparison);
	}

	/**
	 * Filter the query by a related Book object
	 *
	 * @param     Book $book  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function filterByBook($book, $comparison = null)
	{
		if ($book instanceof Book) {
			return $this
				->addUsingAlias(AuthorPeer::ID, $book->getAuthorId(), $comparison);
		} elseif ($book instanceof PropelCollection) {
			return $this
				->useBookQuery()
				->filterByPrimaryKeys($book->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByBook() only accepts arguments of type Book or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the Book relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function joinBook($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Book');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Book');
		}

		return $this;
	}

	/**
	 * Use the Book relation Book object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Pixel\CoreBundle\Model\BookQuery A secondary query class using the current class as primary query
	 */
	public function useBookQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinBook($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Book', '\Pixel\CoreBundle\Model\BookQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Author $author Object to remove from the list of results
	 *
	 * @return    AuthorQuery The current query, for fluid interface
	 */
	public function prune($author = null)
	{
		if ($author) {
			$this->addUsingAlias(AuthorPeer::ID, $author->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseAuthorQuery