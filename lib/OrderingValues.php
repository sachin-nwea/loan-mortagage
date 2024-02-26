<?php
class OrderingValues
{
    public function setBranchOrderingValues()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'bank Name',
            'branch_name' => 'Branch Name',
            'branch_area' => 'Branch Area',
            'state' => 'State',
            'city' => 'City',
            'branch_code' => 'Branch Code',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];
    }

    public function setCustomerOrderingValues()
    {
        return [
            'id' => 'ID',
            'f_name' => 'First Name',
            'l_name' => 'Last Name',
            'phone' => 'Phone',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];
    }

    public function setMortgagesOrderingValues()
    {
        return  [
            'id' => 'ID',
            'customers_name' => 'Customer Name',
            'bank_name' => 'Bank Name',
            'branch_name' => 'Branch Name',
        ];
    }

    public function setOrnmentsOrderingValues()
    {
        return [
            'id' => 'ID',
            'ornament_name' => 'Ornament Name',
            'ornament_type' => 'Ornament Type',
            'created_at' => 'Created at',
            'updated_at' => 'Updated at'
        ];
    }

    public function setUsersOrderingValues()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'admin_type' => 'Admin Type'
        ];
    }

    public function setBankOrderingValues()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'Bank Name',
        ];
    }

    public function setBankOptionOrderingValues()
    {
        return [
            'id' => 'ID',
            'bank_name' => 'Bank Name',
        ];
    }
}