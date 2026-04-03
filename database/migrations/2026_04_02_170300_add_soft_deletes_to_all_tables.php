<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'users',
            'companies',
            'designations',
            'shifts',
            'leave_types',
            'leaves',
            'attendances',
            'salary_components',
            'salary_templates',
            'salaries',
            'loans',
            'payrolls',
            'performances',
            'goals',
            'appraisals',
            'recruitment_jobs',
            'candidates',
            'applications',
            'interviews',
            'documents',
            'calendar_events',
            'workflows',
            'workflow_steps',
            'employee_workflows',
            'employee_workflow_steps',
            'checklists',
            'checklist_items',
            'pricings',
            'pricing_features'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'deleted_at')) {
                        $table->softDeletes();
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'companies',
            'designations',
            'shifts',
            'leave_types',
            'leaves',
            'attendances',
            'salary_components',
            'salary_templates',
            'salaries',
            'loans',
            'payrolls',
            'performances',
            'goals',
            'appraisals',
            'recruitment_jobs',
            'candidates',
            'applications',
            'interviews',
            'documents',
            'calendar_events',
            'workflows',
            'workflow_steps',
            'employee_workflows',
            'employee_workflow_steps',
            'checklists',
            'checklist_items',
            'pricings',
            'pricing_features'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'deleted_at')) {
                        $table->dropSoftDeletes();
                    }
                });
            }
        }
    }
};
