<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'news_content' => $this->news_content,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'author' => $this->author,
            // 'writter' => $this->whenLoaded('writer')
            'writer' => $this->whenLoaded('writer', function () {
                return [
                    'id' => $this->writer->id,
                    'username' => $this->writer->username,
                    'firstname' => $this->writer->firstname,
                    'lastname' => $this->writer->lastname,
                ];
            }),
            'comments' => $this->whenLoaded('comments', function (){
                return collect($this->comments)->each(function ($comment){
                    $comment->commentator;
                    return $comment;
                });
            }),
            'comment_total' => $this->whenLoaded('comments', function(){
                return count($this->comments);
            })
        ];
        // return parent::toArray($request);
    }
}
