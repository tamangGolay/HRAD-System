<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="{{asset('css/bose.css')}}" rel="stylesheet"> 
<style>
table, th, td {
  border: 1px solid black;
  margin-left:1px;
  margin-right:1px;
  /* width:100%; */
}
</style>
<div class="row"> 
    <div class="col">
        <div class="card card-green ">
            <div class="card-header bg-green">
                <div class="rvheading bg-green d-flex justify-content-center"><h3>Uniform</h3></div>
            </div><!--/card-header-->
      <br>
            <form method="POST" action="/uniform" enctype="multipart/form-data" accept-charset="UTF-8" >
                @csrf
                <input type="hidden" name="token" id="tokenid" value="{{ csrf_token()}}">
                <!-- <input type="hidden" id="did" name="frId"> -->
                <div class="cardbody">
                
                <div class="form-group row"> 
                <label class="col-md-4 col-form-label text-md-right"  for="user">&nbsp;&nbsp;&nbsp;Employee Id:</label>              
                    <div class="col-sm-10 col-md-6 col-lg-4">
                        <input type="number" onKeyPress="if(this.value.length==8) return false; 
                        if( isNaN(String.fromCharCode(event.keyCode))) return false;"
                        class="form-control" value="{{ old('emp_id') }}"  autocomplete="off" name="emp_id" id="emp_id" placeholder="Employee Id" 
                        onKeyup="if(this.value.length==8 || this.value[0] != 3)
                        getEmployeeDetails(this.value)
                        if(this.value[0] == 3)
                        nima (this.value);" required>
                    </div>
                    <div class="col-sm-2">
                        <span id="empid" class="text-danger"></span>
                    </div>
                </div>
    
                <div class="form-group row"> 
                <label class="col-md-4 col-form-label text-md-right" for="nameid">&nbsp;&nbsp;&nbsp;Name:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="text" name="name" class="form-control" id="nameid" placeholder="Name" readonly required>
                    </div>
                </div> 
                
                <div class="form-group row"> 
                <label class="col-md-4 col-form-label text-md-right" for="office">&nbsp;&nbsp;&nbsp;Div/Dept/Wing:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="text" class="form-control" name="office" id="office" placeholder="office" readonly required>                  
                    </div>
                </div> 
                <input type="hidden" class="form-control" name="officeId" id="officeId" readonly required>                  
            
            <div class="form-group row"> 
                <label class="col-md-4 col-form-label text-md-right" for="contact_number">&nbsp;&nbsp;&nbsp;Contact number:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number" readonly required>                  
                    </div>
                </div>

                <div class="form-group row"> 
                <label class="col-md-4 col-form-label text-md-right" for="designation">&nbsp;&nbsp;&nbsp;Designation:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" readonly required>                  
                    </div>
                </div>
                <input type="hidden" class="form-control" name="designationID" id="designationID" readonly required>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="1" name="pant_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Pant Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">

                    <select class="form-control" name="pant" id="officeName"  required>
                            <option value="">Select Size</option>
                            @foreach($pant as $pant)
                            <option value="{{$pant->id}}"
                                @if ($pant->pantSizeName == '---For New Employee---') disabled @endif>
                             
                            {{$pant->pantSizeName}}</option>
				
                            @endforeach
                    </select>

                    </div>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal2">Pant size</button>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="2" name="shirt_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Shirt Size:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">
                        <select class="form-control" name="shirt" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($shirt as $shirt)
                            <option value="{{$shirt->id}}"
                                @if ($shirt->shirtSizeName == '---For New Employee---') disabled @endif>
                             
                            {{$shirt->shirtSizeName}}</option>
				
                            @endforeach
                    </select>             
                        </div>
                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal">Shirt size</button>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="3" name="jacket_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Jacket Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <select class="form-control" name="jacket" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($jacket as $jacket)
                            <option value="{{$jacket->id}}">{{$jacket->sizeName}}</option>
                            @endforeach
                    </select>                
                    </div>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal1">Jacket size</button>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="4" name="shoe_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Shoe Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <select class="form-control" name="shoe" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($shoe as $shoe)
                            <option value="{{$shoe->id}}">{{$shoe->euShoeSize}}</option>
                            @endforeach
                    </select>                     
                    </div>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal3">Shoe size</button>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="5" name="jumboot_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Gumboot Size:</label>
                    <div class="col-sm-10 col-md-6 col-lg-4">
                    <select class="form-control" name="gumboot" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($gumboot as $gumboot)
                            <option value="{{$gumboot->id}}">{{$gumboot->eUSize}}</option>
                            @endforeach
                    </select>                   
                    </div>
                </div>

                <div class="form-group row"> 
                    <input type="hidden" class="form-control" value="6" name="raincoat_id">                  
                    <label class="col-md-4 col-form-label text-md-right" for="meeting_name">&nbsp;&nbsp;&nbsp;Raincoat Size:</label>
                        <div class="col-sm-10 col-md-6 col-lg-4">
                        <select class="form-control" name="raincoat" id="officeName" required>
                            <option value="">Select Size</option>
                            @foreach($raincoat as $raincoat)
                            <option value="{{$raincoat->id}}">{{$raincoat->sizeName}}</option>
                            @endforeach
                    </select>   
                        </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col text-right col-form-label col-md-center col-sm-2 col-md-10 col-lg-7">
                        <button type="submit" class="btn btn-outline-success btn-save col-lg-3 text-center" id="bsubmit">{{ __('Save') }}</button>
                    </div>
                </div>   
                </div>
            </form>
            <p class="text-center" style="font-size:16px"><b><i> Note:<i></b><b>choose shirt size or pant size as <i> size(2) ex:XS-Female(2) </i> only if you are getting uniform for the first time</b></p>
        </div>    
    </div>
    <!-- Modal  -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         <!--<h4 class="modal-title">Shirt size</h4>-->
        </div>
        <div class="modal-body" style="width:100%; height:100%">
        <table>
                <tr style="text:centre;">BPC Male Shirt Measurment chart. (Measurment in cms)</tr>
                <tr>
                    <th>Sl no</th>
                    <th>Measurment points</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL </th>
                    <th> 2XL </th>
                    <th> 3XL </th>
                    <th> 4XL </th>
                    <th> 5XL </th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>Round Chest</th>
                    <th>107</th>
                    <th>112</th>
                    <th>117</th>
                    <th>122</th>
                    <th>127</th>
                    <th>132</th>
                    <th>137</th>
                    <th>142</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>Sleeve Length including cuff</th>
                    <th>60</th>
                    <th>61</th>
                    <th>62</th>
                    <th>63</th>
                    <th>64</th>
                    <th>65</th>
                    <th>66</th>
                    <th>67</th>
                </tr>
                <tr>
                    <th>C</th>
                    <th> Centre back length</th>
                    <th>68</th>
                    <th>70</th>
                    <th>70</th>
                    <th>72</th>
                    <th>72</th>
                    <th>74</th>
                    <th>74</th>
                    <th>75</th>
                </tr>
                <tr>
                    <th>D</th>
                    <th>Round Buttom</th>
                    <th>103</th>
                    <th>108</th>
                    <th>113</th>
                    <th>118</th>
                    <th>123</th>
                    <th>128</th>
                    <th>133</th>
                    <th>138</th>
                </tr>

            </table> <br> <br>
            <table>
                <tr style="text:centre;">BPC Female Shirt Measurment chart. (Measurment in cms)</tr>
                <tr>
                    <th>Sl no</th>
                    <th>Measurment points</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL </th>
                    <th> 2XL </th>
                    <th> 3XL </th>
                    <th> 4XL </th>
                    <th> 5XL </th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>Chest</th>
                    <th>100</th>
                    <th>105</th>
                    <th>110</th>
                    <th>115</th>
                    <th>120</th>
                    <th>125</th>
                    <th>130</th>
                    <th>135</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>Waist</th>
                    <th>94</th>
                    <th>99</th>
                    <th>104</th>
                    <th>109</th>
                    <th>114</th>
                    <th>119</th>
                    <th>124</th>
                    <th>129</th>
                </tr>
                <tr>
                    <th>C</th>
                    <th> Bottom</th>
                    <th>100</th>
                    <th>105</th>
                    <th>110</th>
                    <th>115</th>
                    <th>120</th>
                    <th>125</th>
                    <th>130</th>
                    <th>135</th>
                </tr>
                <tr>
                    <th>D</th>
                    <th>Shoulder</th>
                    <th>38</th>
                    <th>40</th>
                    <th>42</th>
                    <th>44</th>
                    <th>46</th>
                    <th>48</th>
                    <th>50</th>
                    <th>52</th>
                </tr>
                <tr>
                    <th>E</th>
                    <th>Sleeve Length</th>
                    <th>54</th>
                    <th>55</th>
                    <th>56</th>
                    <th>57</th>
                    <th>58</th>
                    <th>59</th>
                    <th>60</th>
                    <th>61</th>
                </tr>
                <tr>
                    <th>F</th>
                    <th>Center Back Length</th>
                    <th>66</th>
                    <th>68</th>
                    <th>68</th>
                    <th>70</th>
                    <th>70</th>
                    <th>72</th>
                    <th>72</th>
                    <th>74</th>
                </tr>

            </table> 
        <img src= "shirtMM.jpg" style="border-radius: 1px">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--Modal end-->

  <!-- Modal 1 -->
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!--<h4 class="modal-title">Jacket size</h4>-->
        </div>
        <div class="modal-body" style="width:100%; height:100%">
            <table>
                <tr style="text:centre;">BPC Male Jacket Measurment chart. (Measurment in cms)</tr>
                <tr>
                    <th>Sl no</th>
                    <th>Measurment points</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL </th>
                    <th> 2XL </th>
                    <th> 3XL </th>
                    <th> 4XL </th>
                    <th> 5XL </th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>Round Chest</th>
                    <th>111</th>
                    <th>116</th>
                    <th>121</th>
                    <th>126</th>
                    <th>131</th>
                    <th>136</th>
                    <th>141</th>
                    <th>146</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>Shoulder</th>
                    <th>47</th>
                    <th>49</th>
                    <th>51</th>
                    <th>53</th>
                    <th>55</th>
                    <th>57</th>
                    <th>59</th>
                    <th>61</th>
                </tr>
                <tr>
                    <th>C</th>
                    <th> Sleeve length</th>
                    <th>61</th>
                    <th>62</th>
                    <th>63</th>
                    <th>64</th>
                    <th>65</th>
                    <th>66</th>
                    <th>67</th>
                    <th>68</th>
                </tr>
                <tr>
                    <th>D</th>
                    <th>Buttom</th>
                    <th>107</th>
                    <th>112</th>
                    <th>117</th>
                    <th>122</th>
                    <th>127</th>
                    <th>132</th>
                    <th>137</th>
                    <th>142</th>
                </tr>
                <tr>
                    <th>E</th>
                    <th>Center Back Length</th>
                    <th>69</th>
                    <th>71</th>
                    <th>71</th>
                    <th>73</th>
                    <th>73</th>
                    <th>75</th>
                    <th>75</th>
                    <th>77</th>
                </tr>

            </table> <br> <br>
            <table>
                <tr style="text:centre;">BPC Female Jacket Measurment chart. (Measurment in cms)</tr>
                <tr>
                    <th>Sl no</th>
                    <th>Measurment points</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL </th>
                    <th> 2XL </th>
                    <th> 3XL </th>
                    <th> 4XL </th>
                    <th> 5XL </th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>Round Chest</th>
                    <th>104</th>
                    <th>109</th>
                    <th>114</th>
                    <th>119</th>
                    <th>124</th>
                    <th>129</th>
                    <th>134</th>
                    <th>139</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>Shoulder</th>
                    <th>39</th>
                    <th>41</th>
                    <th>43</th>
                    <th>45</th>
                    <th>47</th>
                    <th>49</th>
                    <th>51</th>
                    <th>53</th>
                </tr>
                <tr>
                    <th>C</th>
                    <th> Sleeve length</th>
                    <th>54</th>
                    <th>55</th>
                    <th>56</th>
                    <th>57</th>
                    <th>58</th>
                    <th>59</th>
                    <th>60</th>
                    <th>61</th>
                </tr>
                <tr>
                    <th>D</th>
                    <th>Buttom</th>
                    <th>104</th>
                    <th>109</th>
                    <th>114</th>
                    <th>119</th>
                    <th>124</th>
                    <th>129</th>
                    <th>134</th>
                    <th>139</th>
                </tr>
                <tr>
                    <th>E</th>
                    <th>Center Back Length</th>
                    <th>67</th>
                    <th>69</th>
                    <th>69</th>
                    <th>71</th>
                    <th>71</th>
                    <th>73</th>
                    <th>73</th>
                    <th>75</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Waist</th>
                    <th>100</th>
                    <th>105</th>
                    <th>110</th>
                    <th>115</th>
                    <th>120</th>
                    <th>125</th>
                    <th>130</th>
                    <th>135</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Zipper Length (Collar to end)</th>
                    <th>66</th>
                    <th>68</th>
                    <th>69</th>
                    <th>70</th>
                    <th>72</th>
                    <th>73</th>
                    <th>75</th>
                    <th>76</th>
                </tr>

            </table> <br> <br>

            <table>
                <tr style="text:centre;">BPC Female Inner Fleece Measurment chart. (Measurment in cms)</tr>
                <tr>
                    <th>Sl no</th>
                    <th>Measurment points</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL </th>
                    <th> 2XL </th>
                    <th> 3XL </th>
                    <th> 4XL </th>
                    <th> 5XL </th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>Round Chest</th>
                    <th>102</th>
                    <th>107</th>
                    <th>112</th>
                    <th>117</th>
                    <th>122</th>
                    <th>127</th>
                    <th>132</th>
                    <th>137</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>Shoulder</th>
                    <th>37</th>
                    <th>39</th>
                    <th>41</th>
                    <th>43</th>
                    <th>45</th>
                    <th>47</th>
                    <th>49</th>
                    <th>51</th>
                </tr>
                <tr>
                    <th>C</th>
                    <th> Sleeve length</th>
                    <th>54</th>
                    <th>55</th>
                    <th>56</th>
                    <th>57</th>
                    <th>58</th>
                    <th>59</th>
                    <th>60</th>
                    <th>61</th>
                </tr>
                <tr>
                    <th>D</th>
                    <th>Buttom</th>
                    <th>102</th>
                    <th>107</th>
                    <th>112</th>
                    <th>117</th>
                    <th>122</th>
                    <th>127</th>
                    <th>132</th>
                    <th>137</th>
                </tr>
                <tr>
                    <th>E</th>
                    <th>Center Back Length</th>
                    <th>61</th>
                    <th>63</th>
                    <th>63</th>
                    <th>65</th>
                    <th>65</th>
                    <th>67</th>
                    <th>67</th>
                    <th>69</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Zipper Length neck to bottom</th>
                    <th>52</th>
                    <th>54</th>
                    <th>54</th>
                    <th>56</th>
                    <th>56</th>
                    <th>58</th>
                    <th>58</th>
                    <th>60</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Zipper Length (Collar to end)</th>
                    <th>66</th>
                    <th>68</th>
                    <th>69</th>
                    <th>70</th>
                    <th>72</th>
                    <th>73</th>
                    <th>75</th>
                    <th>76</th>
                </tr>

            </table>
            <img src= "jacketMM.jpg" style="border-radius: 1px">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--Modal end-->

  <!-- Modal 2 -->
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!--<h4 class="modal-title">Pant size</h4>-->
        </div>
        <div class="modal-body" style="width:100%; height:100%">
            <table>
                <tr style="text:centre;">BPC Male Trouser Measurment chart. (Measurment in cms)</tr>
                <tr>
                    <th>Sl no</th>
                    <th>Measurment points</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL </th>
                    <th> 2XL </th>
                    <th> 3XL </th>
                    <th> 4XL </th>
                    <th> 5XL </th>
                    <th> 6XL </th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>Round Waist</th>
                    <th>71</th>
                    <th>76</th>
                    <th>81</th>
                    <th>86</th>
                    <th>91</th>
                    <th>96</th>
                    <th>101</th>
                    <th>106</th>
                    <th>111</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>Round Hip</th>
                    <th>101</th>
                    <th>106</th>
                    <th>111</th>
                    <th>116</th>
                    <th>121</th>
                    <th>126</th>
                    <th>131</th>
                    <th>136</th>
                    <th>141</th>
                </tr>
                <tr>
                    <th>C</th>
                    <th> Outseam with W.B</th>
                    <th>96</th>
                    <th>98</th>
                    <th>100</th>
                    <th>102</th>
                    <th>104</th>
                    <th>106</th>
                    <th>108</th>
                    <th>110</th>
                    <th>112</th>
                </tr>
                <tr>
                    <th>D</th>
                    <th>Inseam</th>
                    <th>73</th>
                    <th>74</th>
                    <th>75</th>
                    <th>76</th>
                    <th>77</th>
                    <th>78</th>
                    <th>79</th>
                    <th>80</th>
                    <th>81</th>
                </tr>

            </table> <br> <br>

            <table>
                <tr style="text:centre;">BPC Female Trouser Measurment chart. (Measurment in cms)</tr>
                <tr>
                    <th>Sl no</th>
                    <th>Measurment points</th>
                    <th> S </th>
                    <th> M </th>
                    <th> L </th>
                    <th> XL </th>
                    <th> 2XL </th>
                    <th> 3XL </th>
                    <th> 4XL </th>
                    <th> 5XL </th>
                </tr>
                <tr>
                    <th>A</th>
                    <th>Round Waist</th>
                    <th>66</th>
                    <th>71</th>
                    <th>76</th>
                    <th>81</th>
                    <th>86</th>
                    <th>91</th>
                    <th>96</th>
                    <th>101</th>
                </tr>
                <tr>
                    <th>B</th>
                    <th>Round Hip</th>
                    <th>93</th>
                    <th>98</th>
                    <th>103</th>
                    <th>108</th>
                    <th>113</th>
                    <th>118</th>
                    <th>123</th>
                    <th>128</th>
                </tr>
                <tr>
                    <th>C</th>
                    <th> Outseam with W.B</th>
                    <th>88</th>
                    <th>90</th>
                    <th>92</th>
                    <th>94</th>
                    <th>96</th>
                    <th>98</th>
                    <th>100</th>
                    <th>102</th>
                </tr>
                <tr>
                    <th>D</th>
                    <th>Inseam</th>
                    <th>66</th>
                    <th>67</th>
                    <th>68</th>
                    <th>69</th>
                    <th>70</th>
                    <th>71</th>
                    <th>72</th>
                    <th>73</th>
                </tr>
                <tr>
                    <th>E</th>
                    <th>Thigh</th>
                    <th>60.5</th>
                    <th>63</th>
                    <th>65.5</th>
                    <th>68</th>
                    <th>70.5</th>
                    <th>73</th>
                    <th>75.5</th>
                    <th>78</th>
                </tr>

            </table>
            <img src= "pantMM.jpg" style="border-radius: 1px">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--Modal end-->

  <!-- Modal 3 -->
<div class="modal fade" id="myModal3" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <!--<h4 class="modal-title">Shoe size</h4>-->
        </div>
        <div class="modal-body" style="width:100%; height:100%">
            <table style="width:100%">
                <tr>
                    <th>SIZES</th>
                    <th>FOOT LENGTH</th>
                </tr>
                <tr>
                    <th>US</th>
                    <th>EU</th>
                    <th> UK </th>
                    <th >inches </th>
                    <th> cm </th>
                </tr>
                <tr>
                    <th>2</th>
                    <th>36</th>
                    <th> 1 </th>
                    <th> 9.1 </th>
                    <th> 23 </th>
                </tr>
                <tr>
                    <th>3</th>
                    <th>37</th>
                    <th> 2 </th>
                    <th> 9.3 </th>
                    <th> 23.7 </th>
                </tr>
                <tr>
                    <th>4</th>
                    <th>38</th>
                    <th> 3</th>
                    <th> 9.6 </th>
                    <th> 24.4 </th>
                </tr>
                <tr>
                    <th>5</th>
                    <th>39</th>
                    <th> 4 </th>
                    <th> 9.9 </th>
                    <th> 25 </th>
                </tr>
                <tr>
                    <th>6</th>
                    <th>40</th>
                    <th> 5 </th>
                    <th> 10.1 </th>
                    <th> 25.7 </th>
                </tr>
                <tr>
                    <th>7</th>
                    <th>41</th>
                    <th> 6 </th>
                    <th> 10.4 </th>
                    <th> 26.3 </th>
                </tr>
                <tr>
                    <th>7.5</th>
                    <th>41.5</th>
                    <th> 6.5 </th>
                    <th> 10.5 </th>
                    <th> 26.7 </th>
                </tr>
                <tr>
                    <th>8</th>
                    <th>42</th>
                    <th> 7 </th>
                    <th> 10.6 </th>
                    <th> 27 </th>
                </tr>
                <tr>
                    <th>8.5</th>
                    <th>42.5</th>
                    <th> 7.5 </th>
                    <th> 10.8 </th>
                    <th> 27.3 </th>
                </tr>
                <tr>
                    <th>9</th>
                    <th>43</th>
                    <th> 8</th>
                    <th> 10.9 </th>
                    <th> 27.7 </th>
                </tr>
                <tr>
                    <th>9.5</th>
                    <th>43.5</th>
                    <th> 8.5 </th>
                    <th> 11 </th>
                    <th> 28 </th>
                </tr>
                <tr>
                    <th>10</th>
                    <th>44</th>
                    <th> 9 </th>
                    <th> 11.1 </th>
                    <th> 28.3 </th>
                </tr>
                <tr>
                    <th>10.5</th>
                    <th>44.5</th>
                    <th> 9.5 </th>
                    <th> 11.3 </th>
                    <th> 28.7 </th>
                </tr>
                <tr>
                    <th>11</th>
                    <th>45</th>
                    <th> 10 </th>
                    <th> 11.4 </th>
                    <th> 29 </th>
                </tr>
                <tr>
                    <th>12</th>
                    <th>46</th>
                    <th> 11 </th>
                    <th> 11.7 </th>
                    <th> 29.6 </th>
                </tr>
                <tr>
                    <th>13</th>
                    <th>47</th>
                    <th> 12 </th>
                    <th> 11.9 </th>
                    <th> 30.3 </th>
                </tr>
                <tr>
                    <th>14</th>
                    <th>48</th>
                    <th> 13 </th>
                    <th> 12.2 </th>
                    <th> 31 </th>
                </tr>
                <tr>
                    <th>15</th>
                    <th>49</th>
                    <th> 14 </th>
                    <th> 12.5 </th>
                    <th> 31.7 </th>
                </tr>
                <tr>
                    <th>16</th>
                    <th>50</th>
                    <th> 15 </th>
                    <th> 12.7 </th>
                    <th> 32.3 </th>
                </tr>
                <tr>
                    <th>17</th>
                    <th>51</th>
                    <th> 16 </th>
                    <th> 13 </th>
                    <th> 33 </th>
                </tr>

            </table> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!--Modal end-->
</div>

<script type="text/javascript">

function nima()
{
    if(document.getElementById('emp_id').value[0] == '3' ){

		document.getElementById('empid').innerHTML = '';                        

	}
}

function getEmployeeDetails(val)
{

       
    //pulling records using emp_id from users table 
      var csrftoken =document.getElementById('tokenid').value;
          $.get('/getValues?source=user_profile&info='+val+'&token='+csrftoken,function(data){              
                    console.log(data);         
    document.getElementById('nameid').value = '';                      
                    document.getElementById('contact_number').value = '';
                    document.getElementById('designation').value = '';
                    // document.getElementById('fixed').value = '';
                    // document.getElementById('extension').value = '';
                    document.getElementById('office').value =  '';
                                
                    // document.getElementById('dob').value = '';                      
                    // document.getElementById('cid').value = '';
                    // // document.getElementById('blood').value =  '';

                    // document.getElementById('grade').value = '';   
                    // document.getElementById('appointment').value = '';                      
                    // document.getElementById('basicpay').value = '';
                    // document.getElementById('empstatus').value =  '';
                    // document.getElementById('lastdop').value =  '';
                    // document.getElementById('emailid').value = '';   
                    // document.getElementById('office').value = '';                      
                    // // document.getElementById('resignationtype').value =  '';
                    // // document.getElementById('resignationdate').value = '';  
                    // // document.getElementById('qualification').value = '';    
                    // document.getElementById('employmenttype').value = '';                      
                    // document.getElementById('incrementcycle').value = '';
                    
                   
                    document.getElementById('empid').value = '';                        



                    
                $.each(data, function(index, Employee){


                          if(Employee.empId != null)
                          {
                           
                            document.getElementById('nameid').value = Employee.empName;                      
                                document.getElementById('contact_number').value = Employee.mobileNo;
                                document.getElementById('designation').value = Employee.desisNameLong;
                                document.getElementById('designationID').value =  Employee.designationId;
                    //             document.getElementById('extension').value = Employee.extension;
                                document.getElementById('office').value =  Employee.shortOfficeName;                                
                                document.getElementById('officeId').value =  Employee.office;

                    //             document.getElementById('emp_id').innerHTML= Employee.empId;                    
                    // document.getElementById('dob').value = Employee.dob;                      
                    // document.getElementById('cid').value = Employee.cidNo; 
                    // // document.getElementById('blood').value =  Employee.bloodGroup; 
                    // document.getElementById('designationId').value =  Employee.designationId; //pulls id from desination master
                    // document.getElementById('designation').value =  Employee.desisNameLong; 
                  
                    // document.getElementById('grade').value = Employee.grade;
                    // document.getElementById('gradeId').value = Employee.gradeId; 
                    // document.getElementById('empstatus').value = Employee.empStatus;    
   

                    // document.getElementById('appointment').value = Employee.appointmentDate;                       
                    // document.getElementById('basicpay').value = Employee.basicPay; 
                    // document.getElementById('lastdop').value =  Employee.lastDop; 
                    // document.getElementById('emailid').value = Employee.emailId;    
                    // //  document.getElementById('placeId').value = Employee.id;  //pulls id of officedetailss table
                    // document.getElementById('office').value = Employee.office; //pulls id from users table                      
                    // // document.getElementById('bankname').value = Employee.bankName; 
                    // // document.getElementById('qualification').value = Employee.qualificationName;
                    // // document.getElementById('accountnumber').value =  Employee.accountNumber; 
                    // // document.getElementById('resignationtype').value =  Employee.resignationType; 
                    // // document.getElementById('resignationtypeId').value =  Employee.resignationTypeId; 
                    // // document.getElementById('resignationdate').value = Employee.resignationDate;    
                    // document.getElementById('employmenttype').value = Employee.employmentType;                       
                    // document.getElementById('incrementcycle').value = Employee.incrementCycle; 
                 
                        
                        }				


                            
                            else {
                                document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
								// document.getElementById('emp_id').value='';
  
                            }                       
                                                         
                            
                })
        });
      
  

}  
$('div.alert').delay(6500).slideUp(300);// Session message  display time


//     //pulling records using emp_id from users table 
//       var csrftoken =document.getElementById('tokenid').value;
//           $.get('/getValues?source=useruniformadd&info='+val+'&token='+csrftoken,function(data){              
//                     console.log(data);
//                     document.getElementById('nameid').value = '';                      
//                     document.getElementById('contact_number').value = '';
//                     document.getElementById('division').value =  '';
//                     document.getElementById('divisionh').value =  '';
//                     document.getElementById('empid').innerHTML = '';                        
                
//                 $.each(data, function(index, Employee){
//                     if(Employee.empName != null)
//                     {
//                         document.getElementById('nameid').value = Employee.empName;                      
//                         // document.getElementById('contactNumber').value = Employee.contactNumber;
//                         document.getElementById('division').value =  Employee.longOfficeName;
//                         // document.getElementById('divisionh').value =  Employee.office;
//                         // document.getElementById('emp_id').innerHTML='';
//                     }				
//                     else 
//                     {
//                         document.getElementById('empid').innerHTML = 'Please check your Employee ID!!!';  
// 				    }                       
//                 })
//             }); 


// 	// //pulling records using cid from checkin table 
// 	// var csrftoken = document.getElementById('tokenid').value;
// 	// $.get('/getValues?source=useruniformadd&info=' + val + '&token=' + csrftoken, function(data) {
// 	// 	console.log(data);
// 	// 	// document.getElementById('nameid').value =  '';
// 	// 	document.getElementById('empid').innerHTML = '';
// 	// 	$.each(data, function(index, Employee) {
// 	// 		if(Employee.empId != null) {                  
// 	// 			document.getElementById('empid').innerHTML = 'Record already exist for this employee!!';
// 	// 			document.getElementById('emp_id').value = '';
// 	// 		}
// 	// 	})
// 	// });


// }  
// $('div.alert').delay(4500).slideUp(300);// Session message  display time
</script>

<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById('contenthead').innerHTML = '<Strong d-flex justify-content center><a href="/home"><i class="fa fa-home" aria-hidden="true">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i></i></a></strong>';
		});

        
		</script>
