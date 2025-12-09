<?php
/**
 * Class Form
 * Deskripsi: Class untuk membuat form input dengan berbagai tipe field
 * Author: Lab10 PHP OOP
 */

class Form {
    private $fields = [];
    private $action;
    private $method = 'POST';
    private $submit = "Submit Form";
    private $enctype = '';
    private $class = 'form-modern';

    /**
     * Constructor
     * @param string $action Action URL form
     * @param string $submit Text tombol submit
     * @param string $method Method form (GET/POST)
     */
    public function __construct($action = '', $submit = 'Submit Form', $method = 'POST') {
        $this->action = $action;
        $this->submit = $submit;
        $this->method = $method;
    }

    /**
     * Set enctype untuk upload file
     * @param string $enctype
     */
    public function setEnctype($enctype) {
        $this->enctype = $enctype;
    }

    /**
     * Set class CSS untuk form
     * @param string $class
     */
    public function setClass($class) {
        $this->class = $class;
    }

    /**
     * Menambahkan field input text
     * @param string $name Nama field
     * @param string $label Label field
     * @param string $value Nilai default
     * @param bool $required Required atau tidak
     */
    public function addTextField($name, $label, $value = '', $required = false) {
        $this->fields[] = [
            'type' => 'text',
            'name' => $name,
            'label' => $label,
            'value' => $value,
            'required' => $required
        ];
    }

    /**
     * Menambahkan field input number
     * @param string $name Nama field
     * @param string $label Label field
     * @param string $value Nilai default
     * @param bool $required Required atau tidak
     * @param int $min Nilai minimum
     */
    public function addNumberField($name, $label, $value = '', $required = false, $min = 0) {
        $this->fields[] = [
            'type' => 'number',
            'name' => $name,
            'label' => $label,
            'value' => $value,
            'required' => $required,
            'min' => $min
        ];
    }

    /**
     * Menambahkan field select
     * @param string $name Nama field
     * @param string $label Label field
     * @param array $options Array options (value => text)
     * @param string $selected Nilai yang dipilih
     * @param bool $required Required atau tidak
     */
    public function addSelectField($name, $label, $options = [], $selected = '', $required = false) {
        $this->fields[] = [
            'type' => 'select',
            'name' => $name,
            'label' => $label,
            'options' => $options,
            'selected' => $selected,
            'required' => $required
        ];
    }

    /**
     * Menambahkan field file upload
     * @param string $name Nama field
     * @param string $label Label field
     * @param bool $required Required atau tidak
     */
    public function addFileField($name, $label, $required = false) {
        $this->fields[] = [
            'type' => 'file',
            'name' => $name,
            'label' => $label,
            'required' => $required
        ];
    }

    /**
     * Menambahkan field hidden
     * @param string $name Nama field
     * @param string $value Nilai field
     */
    public function addHiddenField($name, $value) {
        $this->fields[] = [
            'type' => 'hidden',
            'name' => $name,
            'value' => $value
        ];
    }

    /**
     * Generate dan tampilkan form
     */
    public function displayForm() {
        echo "<form action='" . $this->action . "' method='" . $this->method . "'";
        
        if ($this->enctype) {
            echo " enctype='" . $this->enctype . "'";
        }
        
        echo " class='" . $this->class . "'>";
        
        // Hidden fields
        foreach ($this->fields as $field) {
            if ($field['type'] == 'hidden') {
                echo "<input type='hidden' name='" . $field['name'] . "' value='" . htmlspecialchars($field['value']) . "'>";
            }
        }
        
        echo "<div class='form-grid'>";
        
        // Render fields
        foreach ($this->fields as $field) {
            if ($field['type'] != 'hidden' && $field['type'] != 'file') {
                $this->renderField($field);
            }
        }
        
        echo "</div>";
        
        // File fields (full width)
        foreach ($this->fields as $field) {
            if ($field['type'] == 'file') {
                $this->renderField($field);
            }
        }
        
        // Submit button
        echo "<div class='form-actions'>";
        echo "<button type='submit' name='submit' class='btn btn-primary'>";
        echo "💾 " . $this->submit;
        echo "</button>";
        echo "<a href='index.php?page=user/list' class='btn btn-secondary'>↩️ Kembali</a>";
        echo "</div>";
        
        echo "</form>";
    }

    /**
     * Render field berdasarkan tipe
     * @param array $field Data field
     */
    private function renderField($field) {
        echo "<div class='form-group'>";
        echo "<label for='" . $field['name'] . "'>" . $field['label'];
        
        if (isset($field['required']) && $field['required']) {
            echo " <span class='required'>*</span>";
        }
        
        echo "</label>";
        
        switch ($field['type']) {
            case 'text':
                echo "<input type='text' id='" . $field['name'] . "' name='" . $field['name'] . "'";
                echo " value='" . htmlspecialchars($field['value']) . "'";
                echo " placeholder='Masukkan " . strtolower($field['label']) . "'";
                
                if ($field['required']) {
                    echo " required";
                }
                
                echo ">";
                break;
                
            case 'number':
                echo "<input type='number' id='" . $field['name'] . "' name='" . $field['name'] . "'";
                echo " value='" . htmlspecialchars($field['value']) . "'";
                echo " min='" . $field['min'] . "'";
                echo " placeholder='0'";
                
                if ($field['required']) {
                    echo " required";
                }
                
                echo ">";
                break;
                
            case 'select':
                echo "<select id='" . $field['name'] . "' name='" . $field['name'] . "'";
                
                if ($field['required']) {
                    echo " required";
                }
                
                echo ">";
                echo "<option value=''>-- Pilih " . $field['label'] . " --</option>";
                
                foreach ($field['options'] as $value => $text) {
                    $selected = ($value == $field['selected']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($value) . "' $selected>" . htmlspecialchars($text) . "</option>";
                }
                
                echo "</select>";
                break;
                
            case 'file':
                echo "<input type='file' id='" . $field['name'] . "' name='" . $field['name'] . "' accept='image/*'";
                
                if ($field['required']) {
                    echo " required";
                }
                
                echo ">";
                echo "<small class='form-text'>Format: JPG, PNG, GIF. Maksimal 2MB</small>";
                break;
        }
        
        echo "</div>";
    }

    /**
     * Generate form info/help text
     * @param array $info_items Array informasi
     */
    public function displayFormInfo($info_items = []) {
        if (empty($info_items)) {
            $info_items = [
                'Field yang bertanda <span class="required">*</span> wajib diisi',
                'Pastikan semua data diisi dengan benar sebelum menyimpan'
            ];
        }
        
        echo "<div class='form-info'>";
        echo "<h4>ℹ️ Petunjuk Pengisian:</h4>";
        echo "<ul>";
        
        foreach ($info_items as $item) {
            echo "<li>" . $item . "</li>";
        }
        
        echo "</ul>";
        echo "</div>";
    }
}
?>