<?php
    class Palestrantes_model extends CI_Model {
        
        protected $table 	= 'tbl_portalfarma_palestrantes';
        protected $id 		= 'id_palestrante';

        private $updated_at = false;
        private $deleted_at = false;
        
        public function insert($form_data)
        {
            if(!isset($form_data) || empty($form_data) ){
                return false;
            }
            $this->db->insert($this->table, $form_data);
            return $this->db->insert_id();
        }
        
        public function update($form_data, $id)
        {
            if(!isset($form_data) || empty($form_data) ){
                return false;
            }

            if(!isset($id) || empty($id)){
                return false;
            }
            
            $this->db->where($this->id, $id);
            return $this->db->update($this->table, $form_data);
        }
        
        public function delete($id = null)
        {
            if(! $id ){
                return false;
            }

            $result = $this->db->where($this->id, $id)->get($this->table)->result();

            if(empty($result)){
                return false;
            }
            return $this->db->delete($this->table, array($this->id => $id));
        }

        public function list($rules = null, $joins = null, $select = null, $order_by = ['column' => 'nome' , 'type_order' =>'ASC'] ) {
            
            if (!is_null($select)){
                $select = ",".$select;
            }
            
            $this->db->select("{$this->table}.* {$select}");
            $this->db->from($this->table);
          
            if(!empty($joins)){
                foreach ($joins as $join) {
                    $this->db->join($join['table'], $join['relationship'], $join['type']);
                }
            }

            if(!empty($rules)){
                foreach ($rules as $column => $rule) {
                    $this->db->where_in($column, $rule);
                }
            }

            if($this->deleted_at){
                $this->db->where("{$this->table}.deleted_at", NULL);
            }

            $this->db->order_by($order_by['column'], $order_by['type_order']);

            $query = $this->db->get();
            
            return $query->result();
        }

        public function query($query)
        {
            return $this->db->query($query)->result();
        }

        /*
        * debug last_query
        */
        public function last_query()
        {
            return $this->db->last_query();
        }
		
		public function desativar($id) {
			$this->db->where('id_palestrante', $id);
			return $this->db->update('tbl_portalfarma_palestrantes', ['status' => 0]); 
		}
        
    }
