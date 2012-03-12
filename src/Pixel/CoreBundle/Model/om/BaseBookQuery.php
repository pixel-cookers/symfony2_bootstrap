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
use Pixel\CoreBundle\Model\Book;
use Pixel\CoreBundle\Model\BookPeer;
use Pixel\CoreBundle\Model\BookQuery;

/**
 * Base class that represents a query for the 'book' table.
 *
 * 
 *
 * @method     BookQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     BookQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     BookQuery orderByIsbn($order = Criteria::ASC) Order by the ISBN column
 * @method     BookQuery orderByAuthorId($order = Criteria::ASC) Order by the author_id column
 *
 * @method     BookQuery groupById() Group by the id column
 * @method     BookQuery groupByTitle() Group by the title column
 * @method     BookQuery groupByIsbn() Group by the ISBN column
 * @method     BookQuery groupByAuthorId() Group by the author_id column
 *
 * @method     BookQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     BookQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     BookQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     BookQuery leftJoinAuthor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Author relation
 * @method     BookQuery rightJoinAuthor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Author relation
 * @method     BookQuery innerJoinAuthor($relationAlias = null) Adds a INNER JOIN clause to the query using the Author relation
 *
 * @method     Book findOne(PropelPDO $con = null) Return the first Book matching the query
 * @method     Book findOneOrCreate(PropelPDO $con = null) Return the first Book matching the query, or a new Book object populated from the query conditions when no match is found
 *
 * @method     Book findOneById(int $id) Return the first Book filtered by the id column
 * @method     Book findOneByTitle(string $title) Return the first Book filtered by the title column
 * @method     Book findOneByIsbn(string $ISBN) Return the first Book filtered by the ISBN column
 * @method     Book findOneByAuthorId(int $author_id) Return the first Book filtered by the author_id column
 *
 * @method     array findById(int $id) Return Book objects filtered by the id column
 * @method     array findByTitle(string $title) Return Book objects filtered by the title column
 * @method     array findByIsbn(string $ISBN) Return Book objects filtered by the ISBN column
 * @method     array findByAuthorId(int $author_id) Return Book objects filtered by the author_id column
 *
 * @package    propel.generator.src.Pixel.CoreBundle.Model.om
 */
abstract class BaseBookQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseBookQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Pixel\\CoreBundle\\Model\\Book', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new BookQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    BookQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof BookQuery) {
			return $criteria;
		}
		$query = new BookQuery();
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
	 * @return    Book|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = BookPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(BookPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    Book A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `TITLE`, `ISBN`, `AUTHOR_ID` FROM `book` WHERE `ID` = :p0';
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
			$obj = new Book();
			$obj->hydrate($row);
			BookPeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    Book|array|mixed the result, formatted by the current formatter
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
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(BookPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(BookPeer::ID, $keys, Criteria::IN);
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
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(BookPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the title column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
	 * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $title The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByTitle($title = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($title)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $title)) {
				$title = str_replace('*', '%', $title);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(BookPeer::TITLE, $title, $comparison);
	}

	/**
	 * Filter the query on the ISBN column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByIsbn('fooValue');   // WHERE ISBN = 'fooValue'
	 * $query->filterByIsbn('%fooValue%'); // WHERE ISBN LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $isbn The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByIsbn($isbn = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($isbn)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $isbn)) {
				$isbn = str_replace('*', '%', $isbn);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(BookPeer::ISBN, $isbn, $comparison);
	}

	/**
	 * Filter the query on the author_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByAuthorId(1234); // WHERE author_id = 1234
	 * $query->filterByAuthorId(array(12, 34)); // WHERE author_id IN (12, 34)
	 * $query->filterByAuthorId(array('min' => 12)); // WHERE author_id > 12
	 * </code>
	 *
	 * @see       filterByAuthor()
	 *
	 * @param     mixed $authorId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByAuthorId($authorId = null, $comparison = null)
	{
		if (is_array($authorId)) {
			$useMinMax = false;
			if (isset($authorId['min'])) {
				$this->addUsingAlias(BookPeer::AUTHOR_ID, $authorId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($authorId['max'])) {
				$this->addUsingAlias(BookPeer::AUTHOR_ID, $authorId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(BookPeer::AUTHOR_ID, $authorId, $comparison);
	}

	/**
	 * Filter the query by a related Author object
	 *
	 * @param     Author|PropelCollection $author The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function filterByAuthor($author, $comparison = null)
	{
		if ($author instanceof Author) {
			return $this
				->addUsingAlias(BookPeer::AUTHOR_ID, $author->getId(), $comparison);
		} elseif ($author instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(BookPeer::AUTHOR_ID, $author->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByAuthor() only accepts arguments of type Author or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the Author relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function joinAuthor($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Author');

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
			$this->addJoinObject($join, 'Author');
		}

		return $this;
	}

	/**
	 * Use the Author relation Author object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Pixel\CoreBundle\Model\AuthorQuery A secondary query class using the current class as primary query
	 */
	public function useAuthorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinAuthor($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Author', '\Pixel\CoreBundle\Model\AuthorQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Book $book Object to remove from the list of results
	 *
	 * @return    BookQuery The current query, for fluid interface
	 */
	public function prune($book = null)
	{
		if ($book) {
			$this->addUsingAlias(BookPeer::ID, $book->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseBookQuery