use App\Models\User;
use App\Models\kaizenProposal;

$count = User::count();
$Array;
for ($i = 1; $i <= $count; $i++) {
  $UserCount = kaizen_proposals::where('user_id', $i)->count();
  $Array=array($i=>$UserCount);
}