<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClothM extends Model
{
    use HasFactory;

    protected $table = 'cloth_m';
    protected $primaryKey = 'cm_id';
    public $timestamps = true;

    protected $fillable = [
        'F_cus_id',
        'size',
        'cloth_rate',
        'order_status',
        'Height',
        'chati',
        'Sleeve',
        'Shoulder',
        'Collar',
        'Armpit',
        'Skirt',
        'Trousers',
        'Kaff',
        'size_kaf',
        'Pacha',
        'sleeve_type',
        'size_sleve',
        'Kalar',
        'Shalwar',
        'Yakhan',
        'Daman',
        'Jeb',
        'O_date',
        'R_date'
        
    ];

    protected $casts = [
        'cloth_rate' => 'decimal:2',
        'Sleeve' => 'integer',
        'Shoulder' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'O_date' => 'date',
        'R_date' => 'date',
    ];

    /**
     * Get the customer that owns this cloth measurement.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'F_cus_id', 'cus_id');
    }

    /**
     * Get the cloth assignments for this cloth measurement.
     */
    public function clothAssignments()
    {
        return $this->hasMany(ClothAssignment::class, 'F_cm_id', 'cm_id');
    }

    /**
     * Get available sizes with display names
     */
    public static function getAvailableSizes()
    {
        return [
            'S' => 'Small',
            'L' => 'Large',
        ];
    }

    /**
     * Get available order statuses with display names
     */
    public static function getAvailableOrderStatuses()
    {
        return [
            'pending' => 'Pending',
            'complete' => 'Complete',
        ];
    }

    /**
     * Get available kaff types
     */
    public static function getAvailableKaffTypes()
    {
        return [
            'null' => 'None',
            'گول کف' => 'گول کف (Round Bottom)',
            'چورس کف' => 'چورس کف (Square Bottom)',
            'گول پلیتدار کف' => 'گول پلیتدار کف (Round Pleated Bottom)',
            'چورس پلیت دار کف' => 'چورس پلیت دار کف (Square Pleated Bottom)',
        ];
    }

    /**
     * Get available sleeve types
     */
    public static function getAvailableSleeveTypes()
    {
        return [
            'null' => 'None',
            'ساده' => 'ساده (Plain)',
            'مژه دار' => 'مژه دار (Laced)',
            'دانه دار' => 'دانه دار (Buttoned)',
            'سه توكمه' => 'سه توكمه (Three Button)',
            'یو اینچ خط' => 'یو اینچ خط (One Inch Line)',
            'نیم اینچ خط' => 'نیم اینچ خط (Half Inch Line)',
        ];
    }

    /**
     * Get available kalar (collar) types
     */
    public static function getAvailableKalarTypes()
    {
        return [
            'هندی' => 'هندی (Indian)',
            'قاسمی' => 'قاسمی (Qasimi)',
            'سینه پور' => 'سینه پور (Sinehpur)',
            'کالر' => 'کالر (Collar)',
            'پوره بین' => 'پوره بین (Full Between)',
            'نیمه بین' => 'نیمه بین (Half Between)',
            'عریی' => 'عریی (Arabic)',
        ];
    }

    /**
     * Get available shalwar types
     */
    public static function getAvailableShalwarTypes()
    {
        return [
            'ساده' => 'ساده (Plain)',
            'نیمه گیبی' => 'نیمه گیبی (Half Gathered)',
            'پول گیبی' => 'پول گیبی (Full Gathered)',
            'سه درزه' => 'سه درزه (Three Seam)',
        ];
    }

    /**
     * Get available daman types
     */
    public static function getAvailableDamanTypes()
    {
        return [
            'گول' => 'گول (Round)',
            'چهار کنج' => 'چهار کنج (Four Corner)',
            'دوه اینچ قات' => 'دوه اینچ قات (Two Inch Fold)',
            'دری اینچ قات' => 'دری اینچ قات (Three Inch Fold)',
        ];
    }

    /**
     * Get available jeb (pocket) types
     */
    public static function getAvailableJebTypes()
    {
        return [
            'روي' => 'روي (Front)',
            'بغل' => 'بغل (Side)',
            'تنبان' => 'تنبان (Trouser)',
            'بلوچی تنبان' => 'بلوچی جيب (Balochi Pocket)',
        ];
    }

    /**
     * Get size display name
     */
    public function getSizeDisplayAttribute()
    {
        $sizes = self::getAvailableSizes();
        return $sizes[$this->size] ?? $this->size;
    }

    /**
     * Get order status display name
     */
    public function getOrderStatusDisplayAttribute()
    {
        $statuses = self::getAvailableOrderStatuses();
        return $statuses[$this->order_status] ?? $this->order_status;
    }

    /**
     * Get kaff display name
     */
    public function getKaffDisplayAttribute()
    {
        $types = self::getAvailableKaffTypes();
        return $types[$this->Kaff] ?? $this->Kaff;
    }

    /**
     * Get sleeve type display name
     */
    public function getSleeveTypeDisplayAttribute()
    {
        $types = self::getAvailableSleeveTypes();
        return $types[$this->sleeve_type] ?? $this->sleeve_type;
    }

    /**
     * Get kalar display name
     */
    public function getKalarDisplayAttribute()
    {
        $types = self::getAvailableKalarTypes();
        return $types[$this->Kalar] ?? $this->Kalar;
    }

    /**
     * Get shalwar display name
     */
    public function getShalwarDisplayAttribute()
    {
        $types = self::getAvailableShalwarTypes();
        return $types[$this->Shalwar] ?? $this->Shalwar;
    }

    /**
     * Get daman display name
     */
    public function getDamanDisplayAttribute()
    {
        $types = self::getAvailableDamanTypes();
        return $types[$this->Daman] ?? $this->Daman;
    }

    /**
     * Get jeb types as array (comma separated in database)
     */
    public function getJebTypesAttribute()
    {
        return $this->Jeb ? explode(', ', $this->Jeb) : [];
    }

    /**
     * Set jeb types from array
     */
    public function setJebTypesAttribute($value)
    {
        $this->attributes['Jeb'] = is_array($value) ? implode(', ', $value) : $value;
    }

    /**
     * Get formatted order date
     */
    public function getFormattedOrderDateAttribute()
    {
        return $this->O_date ? $this->O_date->format('M d, Y') : null;
    }

    /**
     * Get formatted receive date
     */
    public function getFormattedReceiveDateAttribute()
    {
        return $this->R_date ? $this->R_date->format('M d, Y') : null;
    }

    /**
     * Check if order is overdue
     */
    public function getIsOverdueAttribute()
    {
        if (!$this->R_date || $this->order_status === 'complete') {
            return false;
        }
        
        return Carbon::now()->gt($this->R_date);
    }

    /**
     * Get days until receive date
     */
    public function getDaysUntilReceiveAttribute()
    {
        if (!$this->R_date || $this->order_status === 'complete') {
            return null;
        }
        
        return Carbon::now()->diffInDays($this->R_date, false);
    }

    /**
     * Get full customer name with order info
     */
    public function getDisplayNameAttribute()
    {
        $customerName = $this->customer->cus_name ?? 'Unknown Customer';
        return "{$customerName} - {$this->size_display} ({$this->order_status_display})";
    }

    /**
     * Scope to filter by order status
     */
    public function scopeByOrderStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    /**
     * Scope to filter by size
     */
    public function scopeBySize($query, $size)
    {
        return $query->where('size', $size);
    }

    /**
     * Scope to filter pending orders
     */
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    /**
     * Scope to filter completed orders
     */
    public function scopeCompleted($query)
    {
        return $query->where('order_status', 'complete');
    }

    /**
     * Scope to filter overdue orders
     */
    public function scopeOverdue($query)
    {
        return $query->where('order_status', 'pending')
                    ->where('R_date', '<', Carbon::now()->toDateString());
    }

    /**
     * Scope to filter by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('O_date', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by customer
     */
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('F_cus_id', $customerId);
    }

    /**
     * Get measurements summary as array
     */
    public function getMeasurementsSummaryAttribute()
    {
        return [
            'Height' => $this->Height,
            'Chati' => $this->chati,
            'Sleeve' => $this->Sleeve,
            'Shoulder' => $this->Shoulder,
            'Collar' => $this->Collar,
            'Armpit' => $this->Armpit,
            'Skirt' => $this->Skirt,
            'Trousers' => $this->Trousers,
            'Pacha' => $this->Pacha,
        ];
    }

    /**
     * Get style options summary as array
     */
    public function getStyleOptionsSummaryAttribute()
    {
        return [
            'Kaff' => $this->kaff_display,
            'Sleeve Type' => $this->sleeve_type_display,
            'Kalar' => $this->kalar_display,
            'Shalwar' => $this->shalwar_display,
            'Daman' => $this->daman_display,
            'Jeb' => $this->Jeb,
            'Yakhan' => $this->Yakhan,
        ];
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Set default order date when creating
        static::creating(function ($model) {
            if (!$model->O_date) {
                $model->O_date = Carbon::now()->toDateString();
            }
        });
    }
}
