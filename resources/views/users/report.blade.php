
<div>
    <div >
      
                   <table >
                    <thead>
                        <th>Pais</th>
                        <th>Cantidad</th>
                    </thead>
                       <tbody>
                           @foreach($users as $user)
                           <tr>
                                <td>{{ $user->country }}</td>
                                <td>{{ $user->cantidad }}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               
       
    </div>
</div>
