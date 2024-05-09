<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait HistoryModelTrait
{
    private array $metaFields = [];
    public abstract function historyMetaFields(): array;

    public function getHistory(): array
    {
        $historyModel = [];
        if (method_exists($this, 'getModelLabel')) {
            $histories = $this->histories()->orderBy('performed_at', 'desc')->get();
            if ($histories->isEmpty()) {
                return $historyModel;
            }
            $this->metaFields = $this->historyMetaFields();
            foreach ($histories as $history) {
                $historyRow = [
                    'message' => $history->message,
                    'performed' => Carbon::parse($history->performed_at)->format('d.m.Y H:i:s'),
                    'user' => User::find($history->user_id),
                    'messages' => [],
                ];
                if (!empty($history->meta)) {
                    foreach ($history->meta as $meta) {
                        if (isset($this->metaFields[$meta['key']])) {
                            $metaFields = $this->metaFields[$meta['key']];
                            $nameField = $metaFields['name'];
                            if (
                                !empty($metaFields['table'])
                                && is_array($metaFields['table'])
                                && !empty($metaFields['table']['label'])
                                && !empty($metaFields['table']['value'])
                            ) {
                                $oldValue = DB::table($metaFields['table']['name'])
                                    ->where($metaFields['table']['value'], $meta['old'])
                                    ->when(!empty($metaFields['table']['locale']), function ($query) {
                                        $query->where('locale', '=', app()->getLocale());
                                    })
                                    ->value($metaFields['table']['label']);
                                $newValue = DB::table($metaFields['table']['name'])
                                    ->where($metaFields['table']['value'], $meta['new'])
                                    ->when(!empty($metaFields['table']['locale']), function ($query) {
                                        $query->where('locale', '=', app()->getLocale());
                                    })
                                    ->value($metaFields['table']['label']);
                            } else {
                                $oldValue = $meta['old'];
                                $newValue = $meta['new'];
                            }
                            $historyRow['messages'][] = $nameField . ' - ' . __('history.old_value') . $oldValue . '; ' . __('history.new_value') . $newValue . "; \n";
                        }
                    }
                }
                $historyModel[] = $historyRow;
            }
        }

        return $historyModel;
    }
}
