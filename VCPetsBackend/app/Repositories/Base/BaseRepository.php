<?php

namespace App\Repositories\Base; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseRepository
{ 
    protected $model;
    private $relations;

    public function __construct(Model $model, array $relations = [])
    {
        $this->model = $model;
        $this->relations = $relations;
    }

    public function all()
    {
        $query = $this->model;

        if(!empty($this->relations)) {
            $query = $query->with($this->relations);
        }

        return $query->get();
    }

    public function show($id)
    {
        try{
            if($id < 0 || !is_numeric($id) ){
              throw new \Exception("Invalid ID supplied",400);
            }

            $query = $this->model;

            if(!empty($this->relations)) {
                $query = $query->with($this->relations);
            }
            
            //Find Model By Id
            $model_by_id = $query->find($id);

            if(!$model_by_id){
              $modelName = substr( strrchr( get_class($this->model), '\\'), 1); 
              throw new ModelNotFoundException($modelName." Not Found",404);
            }
            return $model_by_id;

        } catch (\Exception  $e) {
          abort($e->getCode(),$e->getMessage());
        }
    }

    public function save(Model $model)
    {
        $model->save();

        return $model;
    }

    public function destroy($id)
    {
      $model_by_id = self::show($id);
      return $model_by_id ->delete();
    }
}