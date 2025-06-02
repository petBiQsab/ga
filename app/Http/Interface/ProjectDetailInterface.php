<?php

namespace App\Http\Interface;

use Illuminate\Http\Request;

interface ProjectDetailInterface
{

    public function createDataset($projekt);

    public function createEmptyProject();

    public function storeEditProject(Request $request);

    public function collectCiselniky();

    public function deleteProject(int $id);

    public function rgbWorkflow();

}
