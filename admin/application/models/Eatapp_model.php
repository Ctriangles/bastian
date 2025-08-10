<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eatapp_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Get all reservations from local database
     */
    public function getAllReservations($limit = 50, $offset = 0) {
        $this->db->select('*');
        $this->db->from('eatapp_reservations');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get reservations by status
     */
    public function getReservationsByStatus($status, $limit = 50, $offset = 0) {
        $this->db->select('*');
        $this->db->from('eatapp_reservations');
        $this->db->where('status', $status);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get reservation by ID
     */
    public function getReservationById($id) {
        $this->db->select('*');
        $this->db->from('eatapp_reservations');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    
    /**
     * Get total count of reservations
     */
    public function getTotalReservations() {
        return $this->db->count_all('eatapp_reservations');
    }
    
    /**
     * Get count by status
     */
    public function getReservationCountByStatus($status) {
        $this->db->where('status', $status);
        return $this->db->count_all_results('eatapp_reservations');
    }
    
    /**
     * Get recent reservations (last 7 days)
     */
    public function getRecentReservations($days = 7) {
        $this->db->select('*');
        $this->db->from('eatapp_reservations');
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime("-{$days} days")));
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get availability cache data
     */
    public function getAvailabilityCache($limit = 50) {
        $this->db->select('*');
        $this->db->from('eatapp_availability');
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        $this->db->order_by('cached_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get expired availability cache
     */
    public function getExpiredAvailabilityCache($limit = 50) {
        $this->db->select('*');
        $this->db->from('eatapp_availability');
        $this->db->where('expires_at <=', date('Y-m-d H:i:s'));
        $this->db->order_by('expires_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Clear expired availability cache
     */
    public function clearExpiredAvailabilityCache() {
        $this->db->where('expires_at <=', date('Y-m-d H:i:s'));
        return $this->db->delete('eatapp_availability');
    }
    
    /**
     * Get restaurant data from cache (if exists)
     */
    public function getRestaurantCache() {
        $this->db->select('*');
        $this->db->from('eatapp_restaurants');
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get reservation statistics
     */
    public function getReservationStats() {
        $stats = array();
        
        // Total reservations
        $stats['total'] = $this->getTotalReservations();
        
        // By status
        $stats['confirmed'] = $this->getReservationCountByStatus('confirmed');
        $stats['pending'] = $this->getReservationCountByStatus('pending');
        $stats['failed'] = $this->getReservationCountByStatus('failed');
        
        // Today's reservations
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $stats['today'] = $this->db->count_all_results('eatapp_reservations');
        
        // This week's reservations
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')));
        $stats['this_week'] = $this->db->count_all_results('eatapp_reservations');
        
        // This month's reservations
        $this->db->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')));
        $stats['this_month'] = $this->db->count_all_results('eatapp_reservations');
        
        return $stats;
    }
    
    /**
     * Search reservations
     */
    public function searchReservations($search_term, $limit = 50) {
        $this->db->select('*');
        $this->db->from('eatapp_reservations');
        $this->db->group_start();
        $this->db->like('first_name', $search_term);
        $this->db->or_like('last_name', $search_term);
        $this->db->or_like('email', $search_term);
        $this->db->or_like('phone', $search_term);
        $this->db->or_like('eatapp_reservation_key', $search_term);
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Update reservation status
     */
    public function updateReservationStatus($id, $status) {
        $this->db->where('id', $id);
        return $this->db->update('eatapp_reservations', array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }
    
    /**
     * Delete reservation
     */
    public function deleteReservation($id) {
        $this->db->where('id', $id);
        return $this->db->delete('eatapp_reservations');
    }
} 