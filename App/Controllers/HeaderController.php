<?php

namespace App\Controllers;

use App\Models\HeaderButton;

class HeaderController
{
    private array $buttons = [];
    private string $defaultLocale = '/App/Src/';
    private string $defaultPage = 'index.php?action=';
    private string $default = 'default';
    private string $fullPath;
    public static $defaultFullPath;


    //Default page for "Product_list" (current)
    public function __construct()
    {
        $this->fullPath = "{$this->defaultLocale}{$this->defaultPage}";
        self::$defaultFullPath = "{$this->fullPath}{$this->default}";
    }

    public function addButton(string $name, string $id, string $link, string $type)
    {
        $this->buttons[] = 
        new HeaderButton($name, $id, "{$this->fullPath}{$link}",$type);
    }
    public function setButtons(array ...$buttonData)
    {
        // Clear current buttons and set new ones based on provided data
        $this->clearButtons();
        foreach ($buttonData as $data) {
        if (isset($data['name'], $data['id'], $data['link'])) {
        $this->addButton(
            $data['name'], $data['id'], $data['link'],$data['type']
        );
        } else {
        throw new \InvalidArgumentException(
            "Each button must have 'name', 'id', 'link', and 'type'."
        );
    }
    }
    }
    public function clearButtons()
    {
        $this->buttons = [];
    }
    public function showHeader(string $activePage = null)
    {
        if ($activePage === null) {
            $activePage = $this->defaultLocale;
        }
        // Passing the buttons to the view
        $buttons = $this->buttons;
        require_once '../Views/Header/Header.php';
    }
    public static function getDefaultFullPath()
    {
        return self::$defaultFullPath;
    }


    // Here are function for the pages
    public function main_ProductPage()
    {
        $this->setButtons(
        ['name' => 'Delete', 'id' => 'delete-product-btn', 'link' => 'default','type'=>'button'],
        ['name' => 'Add Product', 'id' => '', 'link' => 'Add_Product','type'=>'button']   
        );
    }
    public function add_ProductPage()
    {
        $this->setButtons(
        ['name' => 'Cancel', 'id' => 'cancel', 'link' => 'default','type'=>'button'],
        ['name' => 'Save', 'id' => 'Save', 'link' => '','type'=>'submit'] 
        );
    }





    // !! For deletions
    // An array for getting buttons
    // public function getButtons(): array
    // {
    //     return $this->buttons;
    // }

    //Function on when clicked update header
    //  public function updateHeader(string $url): void
    //  {
    //      // Determine which page to load based on the URL
    //      $activePage = $this->resolvePage($url);
    //      $this->showHeader($activePage);
    //      // Render header with the active page
    //  }

    //  private function resolvePage(string $url): string
    //  {
    //      // Loop through the buttons to find the matching URL
    //      foreach ($this->buttons as $button) {
    //          if ($button->getLink() === $url) {
    //              // Derive the page name from the button link (e.g., '/Add_Product' => 'Add_Product')
    //              return trim($url);
    //              //return trim($url, '/'); Remove leading/trailing slashes
    //          }
    //      }

    //      // If no match, return the default page
    //      return $this->defaultLocale;
    //  }

    // $this->addButton("Add Product", '', "Add_Product");
    // $this->addButton("Delete", 'delete-product-btn', "default");

}
