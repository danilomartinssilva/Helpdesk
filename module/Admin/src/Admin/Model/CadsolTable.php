<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;
use Zend\Authentication\AuthenticationService;

class CadsolTable
{

    protected $tableGateway;

    public function __construct (TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveSolicitacao (Cadsol $cadsol)
    {
        try {
            $data = array(
                'desc_cadsol' => $cadsol->desc_cadsol,
                'cd_cadcli' => $cadsol->cd_cadcli,
                'cd_cadser' => $cadsol->cd_cadser,
                'desc_cadsol' => $cadsol->desc_cadsol,
                'data_cadsol' => $cadsol->data_cadsol,
                'cd_cadsta' => $cadsol->cd_cadsta
            );
            $insert = $this->tableGateway->insert($data);
            
            if ($insert) {
              
                
                
                return $this->tableGateway->lastInsertValue;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateSolicitacao (Cadsol $cadsol)
    {
        try {
            $data = array(
                'desc_cadsol' => $cadsol->desc_cadsol,
                'cd_cadcli' => $cadsol->cd_cadcli,
                'cd_cadser' => $cadsol->cd_cadser,
                'desc_cadsol' => $cadsol->desc_cadsol,
                'data_cadsol' => $cadsol->data_cadsol,
                'cd_cadsta' => $cadsol->cd_cadsta
            
            // 'id_cadsol'=>$cadsol->id_cadsol
                        );
            $update = $this->tableGateway->update($data, array(
                'id_cadsol' => $cadsol->id_cadsol
            ));
            if ($update) {
                return true;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteSolicitacao ($id)
    {
        try {
            $id = (int) $id;
            $delete = $this->tableGateway->delete(array(
                'id_cadsol' => $id
            ));
            if ($delete) {
                return true;
            }
           
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function count ($where = null)
    {
        try {
            $resultSet = $this->tableGateway->select(function  (Select $select) use( $where)
            {
                if ($where != null) {
                    $select->where($where);
                }
            })
                ->count();
            return $resultSet;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    // public function fetchAll($filter=null,$start=0,$limit=25,$order='id_cadser DESC'){
    public function fetchAll ($filter = null, $start = null, $limit = null, $order = 'id_cadsol DESC')
    {
        try {
            
            $sql = new \Zend\Db\Sql\Sql(($this->tableGateway->getAdapter()));
            $select = $sql->select()->from('viewsolicitacoes');
            
            if ($filter != null) {
                for ($i = 0; $i < count($filter); $i ++) {
                    $select->where($filter[$i]);
                }
            }
            $select->order($order);
            if ($limit > 0 && $start >= 0) {
                $select->offset($start)->limit($limit);
            }
            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = $statement->execute();
            // echo $statement->getSql();
            // print_r($select->getSqlString());
            return $resultSet;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function TempoMedioSolicitacoes($filter=null,$start=0,$limit=25,$order = 'tempo_medio_solicitacoes.desc_cadser DESC'){
        try {
        
        	$sql = new \Zend\Db\Sql\Sql(($this->tableGateway->getAdapter()));
        	$select = $sql->select()->from('tempo_medio_solicitacoes');
        
        	if ($filter != null) {
        		for ($i = 0; $i < count($filter); $i ++) {
        			$select->where($filter[$i]);
        		}
        	}
        	$select->order($order);
        	if ($limit > 0 && $start >= 0) {
        		$select->offset($start)->limit($limit);
        	}
        	$statement = $sql->prepareStatementForSqlObject($select);
        	
        	$resultSet = $statement->execute();
        	
        	// echo $statement->getSql();
        	// print_r($select->getSqlString());
        	return $resultSet;
        } catch (\Exception $e) {
        	return $e->getMessage();
        }
    	
        
        
    }

    public function updateStatusSolicitacao ($value, $id)
    {
        try {
            $dados = array(
                'cd_cadsta' => $value,
                'data_cadsol' => date('Y-m-d H:i:S')
            );
            
            // $this->tableGateway->update($data,array('id_cadcli'=>(int)$data['id_cadcli']));
            $update = $this->tableGateway->update($dados, array(
                'id_cadsol' => (int) $id
            ));
            if ($update) {
                return true;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function RelatorioQuantidadeSolicitacoes ($filter = null)
    {
        $resultSet = $this->tableGateway->select(function  (Select $select) use( $filter)
        {
            $select->columns(array(
                'total' => new Expression('COUNT(*)')
            ));
            if ($filter != null) {
                $select->where($filter);
            }
            $select->join(array(
                'cadsta' => 'cadsta'
            ), 'cadsta.id_cadsta=cadsol.cd_cadsta', array(
                'desc_cadsta' => 'desc_cadsta'
            ), Select::JOIN_INNER);
            $select->group('cadsta.desc_cadsta');
        });
        return $resultSet;
    }

    public function fetchAllTecnico ($filter = null, $start = null, $limit = null, $order = 'id_cadsol DESC')
    {
        try {
            
            $sql = new \Zend\Db\Sql\Sql(($this->tableGateway->getAdapter()));
            $select = $sql->select()->from('viewsolicitacoestecnico');
            
            if ($filter != null) {
                for ($i = 0; $i < count($filter); $i ++) {
                    $select->where($filter[$i]);
                }
            }
            $select->order($order);
            if ($limit > 0 && $start >= 0) {
                $select->offset($start)->limit($limit);
            }
            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = $statement->execute();
            // echo $statement->getSql();
            
            return $resultSet;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Este método retorna um inteiro
     */
    public function solicitacoesPorPeriodo ($filter = null, $limit = 25, $start = 0, $order = 'viewQtdSolicitacoesPeriodo.desc_cadser DESC')
    {
        try {
            
            $sql = new \Zend\Db\Sql\Sql(($this->tableGateway->getAdapter()));
            $select = $sql->select()->from('viewQtdSolicitacoesPeriodo');
            
            if ($filter != null) {
                for ($i = 0; $i < count($filter); $i ++) {
                    $select->where($filter[$i]);
                }
            }
            
            $select->order($order);
            if ($limit > 0 && $start >= 0) {
                $select->offset($start)->limit($limit);
            }
            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = $statement->execute();
            // echo $statement->getSql();
            
            return $resultSet;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function solicitacoesPorUsuario ($filter = null, $start = 0, $limit = 25, $order = 'Chamados DESC')
    {
        try {
            $sql = new \Zend\Db\Sql\Sql(($this->tableGateway->getAdapter()));
            $select = $sql->select()->from('qtdsolicitacoespusuario');
            if ($filter != null) {
                for ($i = 0; $i < count($filter); $i ++) {
                    $select->where($filter[$i]);
                }
            }
            $select->order($order);
            if ($limit > 0 && $start >= 0) {
                $select->offset($start)->limit($limit);
            }
            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = $statement->execute();
            return $resultSet;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function solicitacoesmaisFrequentes($filter=null,$start=0,$limit=25,$order='quantidade DESC'){
        try {
        	$sql = new \Zend\Db\Sql\Sql(($this->tableGateway->getAdapter()));
        	$select = $sql->select()->from('viewsolicitacoesmaisfrequentes');
        	if ($filter != null) {
        		for ($i = 0; $i < count($filter); $i ++) {
        			$select->where($filter[$i]);
        		}
        	}
        	$select->order($order);
        	if ($limit > 0 && $start >= 0) {
        		$select->offset($start)->limit($limit);
        	}
        	$statement = $sql->prepareStatementForSqlObject($select);
        	$resultSet = $statement->execute();
        	return $resultSet;
        } catch (\Exception $e) {
        	return $e->getMessage();
        }
        
        
    }
}

?>