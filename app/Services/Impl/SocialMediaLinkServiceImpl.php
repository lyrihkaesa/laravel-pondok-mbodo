<?php

namespace App\Services\Impl;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\SocialMediaLinkService;

class SocialMediaLinkServiceImpl implements SocialMediaLinkService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function insertUpdateDeleteMany(array $socialMediaLinks, User $user): array
    {
        $socialMediaLinksToUpdate = [];
        $socialMediaLinksToCreate = [];

        foreach ($socialMediaLinks as $value) {
            $socialMediaLinkId = $value['id'] ?? null;

            if ($socialMediaLinkId) {
                // Jika ID tersedia, tambahkan data untuk diperbarui
                $socialMediaLinksToUpdate[$socialMediaLinkId] = $value;
            } else {
                // Jika tidak, tambahkan data untuk pembuatan entri baru
                $socialMediaLinksToCreate[] = $value;
            }
        }

        $socialMediaIds = [];

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Perbarui entri yang ada
            if (!empty($socialMediaLinksToUpdate)) {
                foreach ($socialMediaLinksToUpdate as $socialMediaLinkId => $value) {
                    $user->socialMediaLinks()->find($socialMediaLinkId)->update($value);
                    $socialMediaIds[] = $socialMediaLinkId;
                }
            }

            // Buat entri baru
            if (!empty($socialMediaLinksToCreate)) {
                $createdSocialMediaLinks = $user->socialMediaLinks()->createMany($socialMediaLinksToCreate);
                foreach ($createdSocialMediaLinks as $socialMediaLink) {
                    $socialMediaIds[] = $socialMediaLink->id;
                }
            }

            // Hapus entri yang tidak termasuk dalam $socialMediaIds
            if (!empty($socialMediaIds)) {
                $user->socialMediaLinks()->whereNotIn('id', $socialMediaIds)->delete();
            }

            // Commit
            DB::commit();
            return [
                'is_success' => true,
                'message' => 'Berhasil memperbarui social media sebanyak ' . count($socialMediaIds) . ' data.',
            ];
        } catch (\Exception $e) {
            // Rollback database jika terjadi kesalahan
            DB::rollback();
            return [
                'is_success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
